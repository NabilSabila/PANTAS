<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoService
{
    public function distance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $dlat = deg2rad($lat2 - $lat1);
        $dlng = deg2rad($lng2 - $lng1);
        $a = sin($dlat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dlng / 2) ** 2;

        return 6371 * 2 * atan2(sqrt($a), sqrt(max(0, 1 - $a)));
    }

    public function geocode(string $action, array $params): array
    {
        if (config('maps.provider') === 'geoapify') {
            return $this->geoapify($action, $params);
        }

        return Cache::remember('geo:surabaya:v3:'.md5($action.json_encode($params)), 86400, function () use ($action, $params) {
            return Cache::lock('nominatim-request', 20)->block(5, function () use ($action, $params) {
                $last = Cache::get('nominatim-last', 0);
                $wait = 1 - (microtime(true) - $last);
                if ($wait > 0) {
                    usleep((int) ($wait * 1000000));
                } Cache::put('nominatim-last', microtime(true), 5);
                if ($action === 'search') {
                    foreach (config('wilayah.aliases') as $alias => $standard) {
                        $params['q'] = str_ireplace($alias, $standard, $params['q']);
                    }
                    if (stripos($params['q'], 'surabaya') === false) {
                        $params['q'] .= ', Surabaya, Jawa Timur, Indonesia';
                    }
                    $params['viewbox'] = '112.57,-7.18,112.87,-7.37';
                    $params['bounded'] = 1;
                }
                $result = Http::timeout(12)->withUserAgent('PANTAS/1.0 ('.config('maps.contact_email').')')->get(config('maps.nominatim_url').'/'.$action, $params + ['format' => 'jsonv2', 'addressdetails' => 1, 'accept-language' => 'id', 'countrycodes' => 'id', 'limit' => 6])->throw()->json();

                if (! is_array($result) || ($action === 'search' && ! array_is_list($result))) {
                    throw new \UnexpectedValueException('Respons geocoding tidak valid.');
                }

                return collect($action === 'reverse' ? (isset($result['lat']) ? [$result] : []) : $result)
                    ->filter(fn ($row) => is_array($row) && is_numeric($row['lat'] ?? null) && is_numeric($row['lon'] ?? null) && is_string($row['display_name'] ?? null) && trim($row['display_name']) !== '' && app(SurabayaBoundary::class)->contains((float) $row['lat'], (float) $row['lon']))
                    ->values()->map(fn (array $row) => ['label' => $row['display_name'], 'lat' => (float) $row['lat'], 'lng' => (float) $row['lon'], 'district' => $this->district($row['address'] ?? [])])->all();
            });
        });
    }

    private function geoapify(string $action, array $params): array
    {
        $key = trim((string) config('maps.geoapify_api_key'));
        if ($key === '') {
            throw new \RuntimeException('API key Geoapify belum dikonfigurasi.', 401);
        }
        $cacheKey = 'geo:geoapify:v2:'.hash('sha256', $key.$action.json_encode($params));
        $cached = Cache::get($cacheKey);
        if (is_array($cached)) {
            return $cached;
        }
        $query = ['apiKey' => $key, 'format' => 'geojson', 'lang' => 'id', 'limit' => 6];
        if ($action === 'search') {
            $text = $params['q'];
            foreach (config('wilayah.aliases', []) as $alias => $standard) {
                $text = str_ireplace($alias, $standard, $text);
            }
            $query['text'] = stripos($text, 'surabaya') === false ? $text.', Surabaya, Jawa Timur, Indonesia' : $text;
            $bounds = config('maps.bounds');
            $center = config('maps.default_center');
            $query['filter'] = 'rect:'.implode(',', [$bounds['west'], $bounds['south'], $bounds['east'], $bounds['north']]).'|countrycode:id';
            $query['bias'] = 'proximity:'.$center['lng'].','.$center['lat'];
        } else {
            $query['lat'] = $params['lat'];
            $query['lon'] = $params['lon'];
        }
        $payload = $this->requestGeoapify($action, $query);
        if ($action === 'search' && preg_match('/^(?:jalan|jl\.?)\s/i', $query['text'])) {
            $confidence = collect($payload['features'])->max(fn ($feature) => $feature['properties']['rank']['confidence'] ?? 1);
            if ($confidence !== null && $confidence < 0.6) {
                $structured = $query;
                unset($structured['text']);
                $structured['street'] = explode(',', $query['text'])[0];
                $structured['city'] = 'Surabaya';
                $structured['country'] = 'Indonesia';
                $structured['type'] = 'street';
                $payload = $this->requestGeoapify($action, $structured);
            }
        }
        $rows = [];
        foreach ($payload['features'] as $feature) {
            $properties = $feature['properties'] ?? [];
            $coordinates = $feature['geometry']['coordinates'] ?? [];
            if (($feature['geometry']['type'] ?? null) !== 'Point' || ! is_numeric($coordinates[0] ?? null) || ! is_numeric($coordinates[1] ?? null)) {
                continue;
            }
            $label = $properties['formatted'] ?? implode(', ', array_filter([$properties['address_line1'] ?? null, $properties['address_line2'] ?? null]));
            $lat = (float) $coordinates[1];
            $lng = (float) $coordinates[0];
            if (! is_string($label) || trim($label) === '' || ! app(SurabayaBoundary::class)->contains($lat, $lng)) {
                continue;
            }
            $rows[] = ['label' => $label, 'lat' => $lat, 'lng' => $lng, 'district' => $this->district($properties)];
        }
        if ($rows !== []) {
            Cache::put($cacheKey, $rows, 3600);
        }

        return $rows;
    }

    private function requestGeoapify(string $action, array $query): array
    {
        try {
            $response = Http::acceptJson()->connectTimeout(8)->timeout(15)
                ->withOptions(['verify' => config('maps.ca_bundle') ?: true])
                ->get(config('maps.geoapify_url').'/'.$action, $query);
        } catch (ConnectionException $exception) {
            $tls = str_contains($exception->getMessage(), 'cURL error 60');
            Log::warning('Koneksi geocoding gagal.', ['provider' => 'geoapify', 'action' => $action, 'reason' => $tls ? 'certificate' : 'connection']);
            throw new \RuntimeException($tls ? 'Sertifikat CA geocoding belum valid.' : 'Koneksi geocoding tidak tersedia.');
        }
        if (! $response->successful()) {
            Log::warning('Penyedia geocoding menolak permintaan.', ['provider' => 'geoapify', 'action' => $action, 'status' => $response->status()]);
            throw new \RuntimeException('Permintaan Geoapify gagal.', $response->status());
        }
        $payload = $response->json();
        if (! is_array($payload) || ($payload['type'] ?? null) !== 'FeatureCollection' || ! is_array($payload['features'] ?? null)) {
            throw new \RuntimeException('Respons Geoapify tidak valid.');
        }

        return $payload;
    }

    private function district(array $address): ?string
    {
        foreach (['city_district', 'municipality', 'district', 'suburb', 'county', 'state_district'] as $key) {
            $candidate = preg_replace('/^kecamatan\s+|^kec\.?\s+/i', '', $address[$key] ?? '');
            foreach (config('wilayah.aliases', []) as $alias => $standard) {
                if (strcasecmp($candidate, $alias) === 0) {
                    $candidate = $standard;
                }
            }
            foreach (config('wilayah.kecamatan', []) as $name => $coordinates) {
                if (strcasecmp(str_replace(' ', '', $candidate), str_replace(' ', '', (string) $name)) === 0) {
                    return $name;
                }
            }
        }

        return null;
    }
}
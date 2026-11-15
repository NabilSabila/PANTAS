<?php

namespace App\Services;

class SurabayaBoundary
{
    public function contains(float $lat, float $lng): bool
    {
        $path = config('maps.boundary_path');
        if (! is_file($path)) {
            return false;
        } $feature = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $geometry = $feature['geometry'];
        $polygons = $geometry['type'] === 'Polygon' ? [$geometry['coordinates']] : $geometry['coordinates'];
        foreach ($polygons as $rings) {
            if ($this->ring($lat, $lng, $rings[0])) {
                $hole = false;
                foreach (array_slice($rings, 1) as $inner) {
                    if ($this->ring($lat, $lng, $inner)) {
                        $hole = true;
                        break;
                    }
                } if (! $hole) {
                    return true;
                }
            }
        }

        return false;
    }

    private function ring(float $lat, float $lng, array $ring): bool
    {
        $inside = false;
        $count = count($ring);
        for ($i = 0,$j = $count - 1; $i < $count; $j = $i++) {
            [$xi,$yi] = $ring[$i];
            [$xj,$yj] = $ring[$j];
            $cross = ($lng - $xi) * ($yj - $yi) - ($lat - $yi) * ($xj - $xi);
            if (abs($cross) < 1e-12 && $lng >= min($xi, $xj) && $lng <= max($xi, $xj) && $lat >= min($yi, $yj) && $lat <= max($yi, $yj)) {
                return true;
            }if (($yi > $lat) !== ($yj > $lat) && $lng < ($xj - $xi) * ($lat - $yi) / ($yj - $yi) + $xi) {
                $inside = ! $inside;
            }
        }

        return $inside;
    }
}
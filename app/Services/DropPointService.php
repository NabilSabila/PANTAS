<?php

namespace App\Services;

use App\Models\DropPoint;
use App\Models\User;
use Illuminate\Support\Collection;

class DropPointService
{
    public function forUser(User $user): Collection
    {
        $query = DropPoint::with('wilayah')->where('aktif', true)->whereHas('wilayah', fn ($q) => $q->where('aktif', true));
        $hasCoordinates = $user->alamat_lat !== null && $user->alamat_lng !== null;
        if (! $hasCoordinates && $user->wilayah_id) {
            $query->where('wilayah_id', $user->wilayah_id);
        }$items = $query->get();
        if ($hasCoordinates) {
            return $items->map(function ($point) use ($user) {
                $point->setAttribute('jarak_km', app(GeoService::class)->distance($user->alamat_lat, $user->alamat_lng, $point->lat, $point->lng));

                return $point;
            })->sortBy('jarak_km')->values();
        }

        return $items;
    }
}

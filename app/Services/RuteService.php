<?php

namespace App\Services;

use App\Models\Rute;
use App\Models\RuteHarian;
use App\Models\User;

class RuteService
{
    public function today(User $user): ?Rute
    {
        $existing = RuteHarian::where('petugas_id', $user->id)->whereDate('tanggal', today())->with('rute.titik', 'rute.jadwal', 'rute.wilayah')->first();
        if ($existing && $user->serves($existing->rute->wilayah_id)) {
            return $existing->rute;
        }

        return Rute::with(['titik', 'jadwal', 'wilayah'])->where('petugas_id', $user->id)->whereIn('wilayah_id', $user->areaTugas()->where('aktif', true)->select('wilayah.id'))->where('status', 'aktif')->whereHas('jadwal', fn ($q) => $q->where('status', 'aktif')->whereJsonContains('hari', now()->locale('id')->dayName)->where(fn ($q) => $q->whereNull('tanggal')->orWhereDate('tanggal', '<=', today())))->first();
    }
}

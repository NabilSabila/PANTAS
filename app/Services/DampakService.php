<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\User;

class DampakService
{
    public function forUser(User $user): array
    {
        $laporan = Laporan::where('user_id', $user->id)->where('status', 'selesai')->whereBetween('selesai_at', [now()->startOfMonth(), now()->endOfMonth()])->get();
        $kantong = $laporan->sum(fn ($l) => match ($l->jumlah) {
            '1 kantong' => 1,'2–3 kantong' => 2.5,'4–5 kantong' => 4.5,'Lebih dari 5 kantong' => 6,'1–2 kantong' => 1.5,'3–5 kantong' => 4,'6–10 kantong' => 8,'1-2 kantong' => 1.5,'3-5 kantong' => 4,'6-10 kantong' => 8,'Lebih dari 10 kantong' => 12,default => 0
        });
        $kg = $kantong * config('pantas.kg_per_kantong');

        return ['laporan' => $laporan->count(), 'kantong' => $kantong, 'kg' => $kg, 'emisi' => $kg * config('pantas.faktor_emisi')];
    }
}

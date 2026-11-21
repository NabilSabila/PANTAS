<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\RuteHarian;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KeterlambatanService
{
    public function forUser(User $user): ?array
    {
        $query = RuteHarian::with(['titik', 'rute.wilayah'])->whereDate('tanggal', today())->where('status', 'berjalan');
        if ($user->role === 'petugas') {
            $query->where('petugas_id', $user->id);
        } else {
            $query->whereHas('rute', fn ($q) => $q->where('wilayah_id', $user->wilayah_id));
        } foreach ($query->get() as $run) {
            $point = $run->titik->firstWhere('status', '!=', 'selesai');
            if (! $point) {
                continue;
            } $minutes = max(0, (int) today()->setTimeFromTimeString($point->jam_rencana)->diffInMinutes(now(), false));
            if ($minutes < config('pantas.ambang_terlambat_menit')) {
                continue;
            } DB::transaction(function () use ($run) {
                RuteHarian::whereKey($run->id)->lockForUpdate()->first();
                foreach (User::where('role', 'warga')->where('status', 'aktif')->where('wilayah_id', $run->rute->wilayah_id)->get() as $warga) {
                    $exists = Notifikasi::where('user_id', $warga->id)->where('tipe', 'keterlambatan')->whereDate('created_at', today())->exists();
                    if (! $exists) {
                        app(NotifikasiService::class)->send($warga, 'Informasi keterlambatan rute', 'Pengangkutan di wilayahmu mengalami keterlambatan.', 'keterlambatan', route('warga.jadwal'));
                    }
                }
            });

            return ['kode' => $run->rute->kode, 'menit' => $minutes];
        }

        return null;
    }
}

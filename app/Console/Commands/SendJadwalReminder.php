<?php

namespace App\Console\Commands;

use App\Models\Jadwal;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Console\Command;

class SendJadwalReminders extends Command
{
    protected $signature = 'pantas:pengingat-jadwal';

    protected $description = 'Kirim pengingat satu hari dan satu jam sebelum pengangkutan';

    public function handle(): int
    {
        foreach ([24, 1] as $hours) {
            $target = now()->addHours($hours);
            foreach (Jadwal::with('wilayah')->whereHas('wilayah', fn($query) => $query->where('aktif', true))->where('status', 'aktif')->whereJsonContains('hari', $target->locale('id')->dayName)->get() as $jadwal) {
                $time = $target->copy()->startOfDay()->setTimeFromTimeString($jadwal->jam_mulai);
                if (abs($time->diffInMinutes($target, false)) > 1 || ($jadwal->tanggal && $time->lt($jadwal->tanggal))) {
                    continue;
                }
                foreach (User::where('role', 'warga')->where('status', 'aktif')->where('wilayah_id', $jadwal->wilayah_id)->get() as $user) {
                    Notifikasi::firstOrCreate(['dedupe_key' => $user->id . ':' . $jadwal->id . ':' . $time->format('Y-m-d') . ':' . $hours], ['user_id' => $user->id, 'judul' => 'Pengingat pengangkutan ' . $jadwal->wilayah->nama, 'isi' => 'Pengangkutan dimulai ' . $hours . ' jam lagi, pukul ' . $time->format('H.i') . ' WIB.', 'tipe' => 'jadwal', 'tautan' => route('warga.jadwal')]);
                }
            }
        }

        return self::SUCCESS;
    }
}

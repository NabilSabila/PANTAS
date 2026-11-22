<?php

namespace App\Services;

use App\Models\Rute;
use App\Models\RuteHarian;
use App\Models\RuteHarianTitik;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function start(User $user): RuteHarian
    {
        return DB::transaction(function () use ($user) {
            User::whereKey($user->id)->lockForUpdate()->firstOrFail();
            $rute = $this->today($user);
            abort_unless($rute, 422, 'Belum ada rute yang ditugaskan hari ini.');
            $run = RuteHarian::where('rute_id', $rute->id)->whereDate('tanggal', today())->first();
            $created = $run === null;
            if (! $run) {
                $run = RuteHarian::create(['rute_id' => $rute->id, 'tanggal' => today()->toDateString(), 'petugas_id' => $user->id, 'mulai_at' => now(), 'status' => 'berjalan']);
            }
            if ($created) {
                foreach ($rute->titik as $i => $point) {
                    $run->titik()->create(['rute_titik_id' => $point->id, 'urutan' => $point->urutan, 'nama' => $point->nama, 'keterangan' => $point->keterangan, 'jam_rencana' => $point->jam_rencana, 'lat' => $point->lat, 'lng' => $point->lng, 'status' => $i === 0 ? 'proses' : 'menunggu']);
                }
                app(AktivitasLogger::class)->log('rute', 'Rute '.$rute->kode.' dimulai');
            }

            return $run;
        });
    }

    public function finish(User $user, int $id, ?string $catatan, bool $complete): void
    {
        DB::transaction(function () use ($user, $id, $catatan, $complete) {
            $point = RuteHarianTitik::findOrFail($id);
            $run = RuteHarian::lockForUpdate()->findOrFail($point->rute_harian_id);
            abort_unless($run->petugas_id === $user->id && $run->tanggal->isToday() && $user->serves($run->rute->wilayah_id), 403);
            $point->refresh();
            abort_unless($point->status === 'proses', 422, 'Titik ini bukan titik aktif.');
            $point->catatan = $catatan ?? $point->catatan;
            if ($complete) {
                $point->status = 'selesai';
                $point->selesai_at = now();
            }
            $point->save();
            if ($complete) {
                $next = $run->titik()->where('status', 'menunggu')->first();
                if ($next) {
                    $next->update(['status' => 'proses']);
                } else {
                    $run->update(['status' => 'selesai', 'selesai_at' => now()]);
                }
            }
        });
    }
}

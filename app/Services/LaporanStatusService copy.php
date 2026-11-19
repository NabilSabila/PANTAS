<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\LaporanRiwayat;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class LaporanStatusService
{
    public const STATUSES = ['baru' => 'Baru', 'diterima' => 'Diterima', 'diproses' => 'Diproses', 'menuju_lokasi' => 'Menuju Lokasi', 'selesai' => 'Selesai'];

    public function update(Laporan $laporan, User $actor, array $data): Laporan
    {
        Gate::forUser($actor)->authorize('update', $laporan);

        return DB::transaction(function () use ($laporan, $actor, $data) {
            $laporan = Laporan::lockForUpdate()->findOrFail($laporan->id);
            $old = $laporan->status;
            if ($actor->role === 'petugas' && $old === 'selesai') {
                throw ValidationException::withMessages(['status' => 'Laporan ini sudah selesai ditangani.']);
            }
            $target = $data['status'];
            $keys = array_keys(self::STATUSES);
            $from = array_search($old, $keys, true);
            $to = array_search($target, $keys, true);
            if ($to === false || ($actor->role === 'petugas' && $to < $from)) {
                throw ValidationException::withMessages(['status' => 'Status laporan hanya dapat maju.']);
            }
            if ($actor->role === 'admin') {
                $petugas = isset($data['petugas_id']) ? User::find($data['petugas_id']) : null;
                if ($petugas && ($petugas->role !== 'petugas' || $petugas->status !== 'aktif' || ! $petugas->serves($laporan->wilayah_id))) {
                    throw ValidationException::withMessages(['petugas_id' => 'Petugas harus aktif dan bertugas di wilayah laporan.']);
                }
                $laporan->petugas_id = $petugas?->id;
                $laporan->prioritas = $data['prioritas'] ?? $laporan->prioritas;
                if ($petugas && $target === 'baru') {
                    $target = 'diterima';
                    $to = 1;
                }
                if ($petugas) {
                    app(NotifikasiService::class)->send($petugas, 'Penugasan laporan '.$laporan->nomor, 'Anda ditugaskan menangani laporan ini.', 'laporan', route('petugas.laporan.show', $laporan));
                }
            } elseif (! $laporan->petugas_id) {
                $laporan->petugas_id = $actor->id;
            }
            $laporan->fill(['status' => $target, 'catatan_petugas' => $data['catatan'] ?? $laporan->catatan_petugas, 'estimasi_tiba' => $data['estimasi_tiba'] ?? $laporan->estimasi_tiba, 'selesai_at' => $target === 'selesai' ? ($laporan->selesai_at ?? now()) : null])->save();
            $stages = $to > $from ? array_slice($keys, $from + 1, $to - $from) : [$target];
            foreach ($stages as $stage) {
                LaporanRiwayat::create(['laporan_id' => $laporan->id, 'status' => $stage, 'catatan' => $data['catatan'] ?? null, 'oleh_user_id' => $actor->id]);
            }
            app(NotifikasiService::class)->send($laporan->user, 'Laporan '.$laporan->nomor.' '.strtolower(self::STATUSES[$target]), $data['catatan'] ?? 'Status laporan diperbarui.', 'laporan', route('warga.laporan.show', $laporan));
            app(AktivitasLogger::class)->log('laporan', 'Laporan '.$laporan->nomor.' '.strtolower(self::STATUSES[$target]));

            return $laporan;
        });
    }
}

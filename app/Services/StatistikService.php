<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\User;
use App\Models\Wilayah;

class StatistikService
{
    public function calculate(int $days = 30): array
    {
        $start = today()->subDays($days - 1);
        $reports = Laporan::with('riwayat')->where('created_at', '>=', $start)->get();
        $previous = Laporan::with('riwayat')->whereBetween('created_at', [$start->copy()->subDays($days), $start->copy()->subMicrosecond()])->get();
        $count = $reports->count();
        $done = $reports->where('status', 'selesai')->count();
        $previousDone = $previous->where('status', 'selesai')->count();
        $previousRate = $previous->count() ? $previousDone / $previous->count() * 100 : 0;
        $response = $reports->map(function ($l) {
            $accepted = $l->riwayat->firstWhere('status', 'diterima');

            return $accepted ? $l->created_at->diffInMinutes($accepted->created_at) : null;
        })->filter(fn ($v) => $v !== null)->avg() ?? 0;
        $previousResponse = $previous->map(function ($report) {
            $accepted = $report->riwayat->firstWhere('status', 'diterima');

            return $accepted ? $report->created_at->diffInMinutes($accepted->created_at) : null;
        })->filter(fn ($value) => $value !== null)->avg() ?? 0;
        $completedByDay = Laporan::whereBetween('selesai_at', [$start, now()])->get(['selesai_at'])->groupBy(fn ($report) => $report->selesai_at->toDateString())->map->count();
        $trend = [];
        for ($i = 0; $i < $days; $i++) {
            $date = $start->copy()->addDays($i);
            $trend[] = ['label' => $date->format('d/m'), 'masuk' => $reports->filter(fn ($l) => $l->created_at->isSameDay($date))->count(), 'selesai' => $completedByDay[$date->toDateString()] ?? 0];
        }

        return ['response_delta' => (int) round($response - $previousResponse), 'previous_rate' => $previousRate, 'total_petugas' => User::where('role', 'petugas')->count(), 'all_total' => Laporan::count(), 'all_active' => Laporan::where('status', '!=', 'selesai')->count(), 'all_new' => Laporan::where('status', 'baru')->count(), 'all_done' => Laporan::where('status', 'selesai')->count(), 'warga_baru' => User::where('role', 'warga')->where('created_at', '>=', now()->startOfMonth())->count(), 'statuses' => ['Selesai' => Laporan::where('status', 'selesai')->count(), 'Diproses' => Laporan::whereIn('status', ['diproses', 'menuju_lokasi'])->count(), 'Diterima' => Laporan::where('status', 'diterima')->count(), 'Baru' => Laporan::where('status', 'baru')->count()], 'total' => $count, 'selesai' => $done, 'rate' => $count ? $done / $count * 100 : 0, 'response' => (int) round($response), 'petugas' => User::where('role', 'petugas')->where('status', 'aktif')->count(), 'warga' => User::where('role', 'warga')->count(), 'trend' => $trend, 'kategori' => $reports->groupBy('kategori')->map->count()->sortDesc(), 'wilayah' => Wilayah::where('aktif', true)->get()->map(fn ($w) => ['nama' => $w->nama, 'total' => $reports->where('wilayah_id', $w->id)->count(), 'selesai' => $reports->where('wilayah_id', $w->id)->where('status', 'selesai')->count()])];
    }
}
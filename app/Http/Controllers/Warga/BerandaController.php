<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Laporan;
use App\Services\DampakService;
use App\Services\JadwalService;
use App\Services\KeterlambatanService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BerandaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Laporan::where('user_id', $request->user()->id);
        $items = $request->user()->wilayah_id ? Jadwal::whereHas('wilayah', fn ($query) => $query->where('aktif', true))->where('wilayah_id', $request->user()->wilayah_id)->where('status', 'aktif')->get() : collect();

        return view('warga.beranda.index', ['total' => (clone $query)->where('status', '!=', 'selesai')->count(), 'proses' => (clone $query)->whereIn('status', ['diproses', 'menuju_lokasi'])->count(), 'selesai' => (clone $query)->where('status', 'selesai')->count(), 'recent' => (clone $query)->with('wilayah')->latest()->take(3)->get(), 'dampak' => app(DampakService::class)->forUser($request->user()), 'next' => app(JadwalService::class)->next($items), 'delay' => app(KeterlambatanService::class)->forUser($request->user())]);
    }
}

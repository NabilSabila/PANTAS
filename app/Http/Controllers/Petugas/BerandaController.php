<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\RuteHarian;
use App\Services\KeterlambatanService;
use App\Services\RuteService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BerandaController extends Controller
{
    public function index(Request $request): View
    {
        $rute = app(RuteService::class)->today($request->user());
        $run = $rute ? RuteHarian::with('titik')->where('rute_id', $rute->id)->whereDate('tanggal', today())->first() : null;
        $query = Laporan::visibleTo($request->user())->where('status', '!=', 'selesai');

        return view('petugas.beranda.index', compact('rute', 'run') + ['masuk' => (clone $query)->count(), 'prioritas' => (clone $query)->where('prioritas', 'tinggi')->count(), 'delay' => app(KeterlambatanService::class)->forUser($request->user())]);
    }
}

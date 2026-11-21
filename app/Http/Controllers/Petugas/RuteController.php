<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Petugas\RuteTitikRequest;
use App\Models\RuteHarian;
use App\Services\RuteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RuteController extends Controller
{
    public function index(Request $request, RuteService $service): View
    {
        $rute = $service->today($request->user());
        $run = $rute ? RuteHarian::with('titik')->where('rute_id', $rute->id)->whereDate('tanggal', today())->first() : null;

        return view($request->routeIs('*.skema') ? 'petugas.rute.skema' : 'petugas.rute.index', compact('rute', 'run'));
    }

    public function start(Request $request, RuteService $service): RedirectResponse
    {
        $service->start($request->user());

        return redirect()->route('petugas.rute.index')->with('sukses', 'Rute dimulai.');
    }

    public function point(RuteTitikRequest $request, int $id, RuteService $service): RedirectResponse
    {
        $service->finish($request->user(), $id, $request->catatan, $request->boolean('selesai'));

        return back()->with('sukses', 'Titik rute diperbarui.');
    }
}
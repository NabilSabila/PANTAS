<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StatusRequest;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Wilayah;
use App\Services\LaporanStatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Laporan::visibleTo($request->user())->with(['wilayah', 'user', 'petugas', 'riwayat']);
        if ($request->filled('q')) {
            $term = '%'.$request->string('q').'%';
            $query->where(fn ($q) => $q->where('nomor', 'like', $term)->orWhere('judul', 'like', $term)->orWhere('lokasi_teks', 'like', $term)->orWhereHas('user', fn ($u) => $u->where('nama', 'like', $term)));
        } if ($request->filter === 'prioritas') {
            $query->where('prioritas', 'tinggi')->where('status', '!=', 'selesai');
        } elseif ($request->filter === 'diproses') {
            $query->whereIn('status', ['diterima', 'diproses', 'menuju_lokasi']);
        } elseif (in_array($request->filter, ['baru', 'diterima', 'selesai'])) {
            $query->where('status', $request->filter);
        } if ($request->filled('wilayah')) {
            $query->where('wilayah_id', $request->wilayah);
        } $laporan = $query->latest()->paginate(15)->withQueryString();
        $selected = $laporan->firstWhere('id', (int) $request->laporan) ?? $laporan->first();

        return view('warga.laporan.index', compact('laporan', 'selected') + ['wilayah' => Wilayah::where('aktif', true)->get()]);
    }

    public function show(Laporan $laporan): View
    {
        Gate::authorize('view', $laporan);
        $laporan->load(['user', 'petugas', 'wilayah', 'riwayat']);

        return view('warga.laporan.show', compact('laporan') + ['petugas' => User::where('role', 'petugas')->where('status', 'aktif')->whereHas('areaTugas', fn ($query) => $query->where('wilayah.id', $laporan->wilayah_id)->where('aktif', true))->get()]);
    }

    public function update(StatusRequest $request, Laporan $laporan): RedirectResponse
    {
        app(LaporanStatusService::class)->update($laporan, $request->user(), $request->validated());

        return back()->with('sukses', 'Status laporan diperbarui.');
    }
}
<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\FotoRequest;
use App\Http\Requests\Warga\LaporanRequest;
use App\Models\Laporan;
use App\Models\LaporanRiwayat;
use App\Models\User;
use App\Services\AktivitasLogger;
use App\Services\LaporanNomorGenerator;
use App\Services\NotifikasiService;
use App\Services\WilayahResolver;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class LaporanWizardController extends Controller
{
    public function create(): View
    {
        return view('warga.laporan.wizard-foto');
    }

    public function photo(FotoRequest $request): RedirectResponse
    {
        $old = $request->session()->get('laporan_draft.foto_path');
        $path = $request->file('foto')->store('tmp', 'public');
        if ($old) {
            Storage::disk('public')->delete($old);
        } $request->session()->put('laporan_draft.foto_path', $path);

        return redirect()->route('warga.laporan.detail');
    }

    public function detail(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('laporan_draft.foto_path')) {
            return redirect()->route('warga.laporan.create');
        }

        return view('warga.laporan.wizard-detail', ['draft' => $request->session()->get('laporan_draft', [])]);
    }

    public function saveDetail(LaporanRequest $request): RedirectResponse
    {
        abort_unless($request->session()->has('laporan_draft.foto_path'), 419);
        $request->session()->put('laporan_draft', array_merge($request->session()->get('laporan_draft'), $request->validated()));

        return redirect()->route('warga.laporan.konfirmasi');
    }

    public function confirm(Request $request): View|RedirectResponse
    {
        $draft = $request->session()->get('laporan_draft', []);
        if (! isset($draft['deskripsi'])) {
            return redirect()->route('warga.laporan.detail');
        }

        return view('warga.laporan.wizard-konfirmasi', compact('draft'));
    }

    public function store(Request $request): RedirectResponse
    {
        $draft = $request->session()->get('laporan_draft');
        abort_unless(isset($draft['deskripsi'],$draft['foto_path']) && Storage::disk('public')->exists($draft['foto_path']), 419);
        $validationRequest = LaporanRequest::create('/', 'POST', $draft);
        $validator = Validator::make($draft, $validationRequest->rules(), $validationRequest->messages());
        if ($validator->fails()) {
            return redirect()->route('warga.laporan.detail')->withErrors($validator)->withInput($draft);
        }$path = 'laporan/'.basename($draft['foto_path']);
        Storage::disk('public')->copy($draft['foto_path'], $path);
        try {
            $laporan = DB::transaction(function () use ($request, $draft, $path) {
                $draft['foto_path'] = $path;
                $draft['user_id'] = $request->user()->id;
                $draft['wilayah_id'] = app(WilayahResolver::class)->resolve($draft['lat'], $draft['lng'], $draft['wilayah_id'] ?? $request->user()->wilayah_id);
                $draft['prioritas'] = $draft['kategori'] === 'b3' || $draft['kondisi'] === 'Menumpuk dan berbau' || $draft['jumlah'] === 'Lebih dari 5 kantong' ? 'tinggi' : 'normal';
                $laporan = Laporan::create($draft);
                $laporan->update(['nomor' => app(LaporanNomorGenerator::class)->generate($laporan)]);
                LaporanRiwayat::create(['laporan_id' => $laporan->id, 'status' => 'baru', 'oleh_user_id' => $request->user()->id, 'catatan' => 'Foto dan detail laporan berhasil dikirim.']);
                foreach (User::where('role', 'petugas')->where('status', 'aktif')->whereHas('areaTugas', fn ($query) => $query->where('wilayah.id', $laporan->wilayah_id)->where('aktif', true))->get() as $petugas) {
                    // Tautan lama disimpan; notifikasi diarahkan ke Beranda selama fitur Petugas lain belum aktif.
                    // app(NotifikasiService::class)->send($petugas, 'Laporan baru '.$laporan->nomor, $laporan->judul, 'laporan', route('petugas.laporan.show', $laporan));
                    app(NotifikasiService::class)->send($petugas, 'Laporan baru '.$laporan->nomor, $laporan->judul, 'laporan', route('petugas.beranda'));
                } app(AktivitasLogger::class)->log('laporan', $laporan->prioritas === 'tinggi' ? 'Laporan prioritas tinggi masuk' : 'Laporan '.$laporan->nomor.' masuk');

                return $laporan;
            });
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($path);
            throw $e;
        }
        Storage::disk('public')->delete($draft['foto_path']);
        $request->session()->forget('laporan_draft');

        return redirect()->route('warga.laporan.terkirim', $laporan);
    }

    public function sent(Laporan $laporan): View
    {
        Gate::authorize('view', $laporan);

        return view('warga.laporan.terkirim', compact('laporan'));
    }
}

<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // Halaman utama: Daftar laporan & pelacakan status
    public function index()
    {
        $userId = Auth::id() ?? 1; // Fallback ID jika belum login
        $laporans = Laporan::where('user_id', $userId)->latest()->get();
        $selectedLaporan = $laporans->first(); // Default pilih laporan teratas untuk tracking

        return view('warga.laporan', compact('laporans', 'selectedLaporan'));
    }

    // Detail / Pilih Laporan untuk dilacak
    public function show($id)
    {
        $userId = Auth::id() ?? 1;
        $laporans = Laporan::where('user_id', $userId)->latest()->get();
        $selectedLaporan = Laporan::findOrFail($id);
        
        return view('warga.detail-laporan', compact('selectedLaporan'));
    }

    public function create(Request $request)
    {
        $step = $request->query('step', 1);

        if ($step == 1 && !$request->has('back')) {
            session()->forget('laporan_data');
        }

        $data = session('laporan_data', []);

        return view('warga.buat-laporan', compact('step', 'data'));
    }

    public function postCreate(Request $request)
    {
        $step = $request->input('step');
        $data = session('laporan_data', []);

        if ($step == 1) {
            // Jika user mengunggah file baru
            if ($request->hasFile('foto')) {
                $request->validate([
                    'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
                ]);
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Simpan ke disk public secara fisik
                $path = $file->storeAs('laporan', $filename, 'public');
                
                // Simpan path relatif yang ringan di session
                $data['foto'] = 'storage/' . $path;
                session(['laporan_data' => $data]);
            } 
            elseif (!isset($data['foto'])) {
                return back()->withErrors(['foto' => 'Silakan unggah foto terlebih dahulu.']);
            }

            return redirect()->route('warga.laporan.create', ['step' => 2]);
        } 
        elseif ($step == 2) {
            $request->validate([
                'kategori_sampah' => 'required|string',
                'kondisi' => 'required|string',
                'jumlah' => 'required|string',
                'lokasi' => 'required|string',
                'deskripsi' => 'required|string',
            ]);

            $data = array_merge($data, $request->except(['_token', 'step']));
            session(['laporan_data' => $data]);

            return redirect()->route('warga.laporan.create', ['step' => 3]);
        }

        return redirect()->route('warga.laporan.create', ['step' => 1]);
    }

    public function store(Request $request)
    {
        $data = session('laporan_data', []);

        if (empty($data)) {
            return redirect()->route('warga.laporan.create')->with('error', 'Data laporan tidak ditemukan.');
        }

        // Buat kode laporan unik
        $kode = 'LP-' . strtoupper(uniqid());

        // Simpan ke database dengan aman (tidak bikin memory exhausted)
        $laporan = \App\Models\Laporan::create([
            'kode_laporan' => $kode,
            'user_id' => auth()->id() ?? 1,
            'foto' => $data['foto'] ?? null,
            'kategori_sampah' => $data['kategori_sampah'] ?? '',
            'kondisi' => $data['kondisi'] ?? '',
            'jumlah' => $data['jumlah'] ?? '',
            'lokasi' => $data['lokasi'] ?? '',
            'deskripsi' => $data['deskripsi'] ?? '',
            'status' => 'Menunggu Verifikasi',
        ]);

        // Hapus session setelah berhasil disimpan
        session()->forget('laporan_data');

        // Arahkan ke halaman sukses/konfirmasi terkirim
        return view('warga.konfirmasi', compact('laporan'));
    }
};
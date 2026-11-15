<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\Jadwal;
use App\Models\Laporan;
use App\Models\User;
use App\Services\JadwalService;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $jadwal = Jadwal::with('wilayah')->whereHas('wilayah', fn($query) => $query->where('aktif', true))->where('status', 'aktif')->get();

        return view('landing.index', ['edukasi' => Edukasi::publishedFor('warga')->latest('published_at')->take(4)->get(), 'warga' => User::where('role', 'warga')->count(), 'selesai' => Laporan::where('status', 'selesai')->count(), 'jadwal' => $jadwal, 'next' => app(JadwalService::class)->next($jadwal)]);
    }
}

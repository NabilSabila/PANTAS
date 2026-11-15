<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Services\JadwalService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(Request $request, JadwalService $service): View
    {
        $items = $request->user()->wilayah_id ? Jadwal::whereHas('wilayah', fn($query) => $query->where('aktif', true))->where('wilayah_id', $request->user()->wilayah_id)->where('status', 'aktif')->get() : collect();

        return view('warga.jadwal.index', compact('items') + ['next' => $service->next($items)]);
    }
}

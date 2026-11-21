<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    public function index(Request $request): View
    {
        return view('petugas.pengaturan.notifikasi', ['items' => $request->user()->notifikasiAkun()->latest()->paginate(20), 'unread' => $request->user()->notifikasiAkun()->whereNull('dibaca_at')->count()]);
    }

    public function read(Request $request, ?int $id = null): RedirectResponse
    {
        $query = $request->user()->notifikasiAkun();
        if ($id) {
            $item = $query->findOrFail($id);
            $item->update(['dibaca_at' => now()]);

            return $item->tautan ? redirect()->to($item->tautan) : back();
        } $query->whereNull('dibaca_at')->update(['dibaca_at' => now()]);

        return back()->with('sukses', 'Semua notifikasi ditandai dibaca.');
    }
}

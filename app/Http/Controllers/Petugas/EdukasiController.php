<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\View\View;

class EdukasiController extends Controller
{
    public function index(): View
    {
        return view('petugas.edukasi.index', ['konten' => Edukasi::publishedFor('petugas')->latest('published_at')->get()]);
    }

    public function show(string $slug): View
    {
        abort_unless(ctype_digit($slug), 404);

        return $this->content(Edukasi::findOrFail((int) $slug));
    }

    public function content(Edukasi $edukasi): View
    {
        abort_unless(Edukasi::publishedFor('petugas')->whereKey($edukasi->id)->exists(), 404);

        return view('petugas.edukasi.konten-admin', compact('edukasi'));
    }
}

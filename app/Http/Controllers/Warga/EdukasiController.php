<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Services\DropPointService;
use Illuminate\View\View;

class EdukasiController extends Controller
{
    public function index(): View
    {
        return view('warga.edukasi.index', ['konten' => Edukasi::publishedFor('warga')->latest('published_at')->get(), 'dropPoint' => app(DropPointService::class)->forUser(auth()->user())->first()]);
    }

    public function show(string $slug): View
    {
        abort_unless(ctype_digit($slug), 404);

        return $this->content(Edukasi::findOrFail((int) $slug));
    }

    public function content(Edukasi $edukasi): View
    {
        abort_unless(Edukasi::publishedFor('warga')->whereKey($edukasi->id)->exists(), 404);

        return view('warga.edukasi.konten-admin', compact('edukasi'));
    }
}

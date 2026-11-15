<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfilRequest;
use App\Models\Wilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function show(Request $request): View
    {
        return view('admin.profil.show', [
            'user' => $request->user()->load('wilayah'),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('admin.profil.edit', [
            'user' => $request->user(),
            'wilayah' => Wilayah::where('aktif', true)->orderBy('nama')->get(),
        ]);
    }

    public function update(ProfilRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['avatar']);
        $data['name'] = $data['nama'];

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('avatar', 'public');
        }

        $request->user()->update($data);

        return redirect()->route('admin.profil')
            ->with('sukses', 'Perubahan profil berhasil disimpan.');
    }
}

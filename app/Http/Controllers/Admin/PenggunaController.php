<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PenggunaStoreRequest;
use App\Http\Requests\Admin\PenggunaUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class PenggunaController extends ResourceController
{
    protected string $model = User::class;

    protected string $feature = 'pengguna';

    public function store(PenggunaStoreRequest $request): RedirectResponse
    {
        return $this->persist($request);
    }

    public function update(PenggunaUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->persist($request, $id);
    }
}

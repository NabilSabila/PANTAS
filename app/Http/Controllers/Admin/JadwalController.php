<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\JadwalStoreRequest;
use App\Http\Requests\Admin\JadwalUpdateRequest;
use App\Models\Jadwal;
use Illuminate\Http\RedirectResponse;

class JadwalController extends ResourceController
{
    protected string $model = Jadwal::class;

    protected string $feature = 'jadwal';

    public function store(JadwalStoreRequest $request): RedirectResponse
    {
        return $this->persist($request);
    }

    public function update(JadwalUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->persist($request, $id);
    }
}

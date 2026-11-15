<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\EdukasiStoreRequest;
use App\Http\Requests\Admin\EdukasiUpdateRequest;
use App\Models\Edukasi;
use Illuminate\Http\RedirectResponse;

class EdukasiController extends ResourceController
{
    protected string $model = Edukasi::class;

    protected string $feature = 'edukasi';

    public function store(EdukasiStoreRequest $request): RedirectResponse
    {
        return $this->persist($request);
    }

    public function update(EdukasiUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->persist($request, $id);
    }
}

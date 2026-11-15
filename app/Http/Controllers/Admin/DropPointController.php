<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DropPointStoreRequest;
use App\Http\Requests\Admin\DropPointUpdateRequest;
use App\Models\DropPoint;
use Illuminate\Http\RedirectResponse;

class DropPointController extends ResourceController
{
    protected string $model = DropPoint::class;

    protected string $feature = 'drop-point';

    public function store(DropPointStoreRequest $request): RedirectResponse
    {
        return $this->persist($request);
    }

    public function update(DropPointUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->persist($request, $id);
    }
}

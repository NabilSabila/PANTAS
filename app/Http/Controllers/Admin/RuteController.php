<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RuteStoreRequest;
use App\Http\Requests\Admin\RuteUpdateRequest;
use App\Models\Rute;
use Illuminate\Http\RedirectResponse;

class RuteController extends ResourceController
{
    protected string $model = Rute::class;

    protected string $feature = 'rute';

    public function store(RuteStoreRequest $request): RedirectResponse
    {
        return $this->persist($request);
    }

    public function update(RuteUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->persist($request, $id);
    }
}

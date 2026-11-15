<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Services\DropPointService;
use Illuminate\View\View;

class DropPointController extends Controller
{
    public function index(): View
    {
        return view('warga.drop-point.index', ['items' => app(DropPointService::class)->forUser(auth()->user())]);
    }
}

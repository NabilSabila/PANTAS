<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AktivitasLog;
use Illuminate\View\View;

class AktivitasController extends Controller
{
    public function index(): View
    {
        return view('admin.aktivitas.index', ['items' => AktivitasLog::latest()->paginate(20)]);
    }
}
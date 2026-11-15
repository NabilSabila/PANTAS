<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function index(): View
    {
        return view('warga.pengaturan.index');
    }
}

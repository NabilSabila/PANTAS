<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AktivitasLog;
use App\Services\StatistikService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $days = in_array((int) $request->hari, [7, 30, 90], true) ? (int) $request->hari : 30;

        return view('admin.dashboard.index', ['stats' => app(StatistikService::class)->calculate($days), 'days' => $days, 'activities' => AktivitasLog::latest()->take(5)->get()]);
    }
}
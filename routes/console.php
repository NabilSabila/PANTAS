<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('pantas:pengingat-jadwal')->everyMinute()->withoutOverlapping();

Schedule::call(function (): void {
    foreach (Storage::disk('public')->files('tmp') as $path) {
        if (Storage::disk('public')->lastModified($path) < now()->subDay()->timestamp) {
            Storage::disk('public')->delete($path);
        }
    }
})->daily();

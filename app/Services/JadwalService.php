<?php

namespace App\Services;

use Illuminate\Support\Collection;

class JadwalService
{
    public function next(Collection $items): ?array
    {
        $options = [];
        foreach ($items as $jadwal) {
            for ($i = 0; $i < 8; $i++) {
                $date = today()->addDays($i);
                if (in_array($date->locale('id')->dayName, $jadwal->hari, true) && (! $jadwal->tanggal || $date->gte($jadwal->tanggal)) && $date->copy()->setTimeFromTimeString($jadwal->jam_selesai)->isFuture()) {
                    $options[] = ['date' => $date, 'jadwal' => $jadwal];
                    break;
                }
            }
        }
        usort($options, fn($a, $b) => ($a['date']->format('Y-m-d') . $a['jadwal']->jam_mulai) <=> ($b['date']->format('Y-m-d') . $b['jadwal']->jam_mulai));

        return $options[0] ?? null;
    }
}

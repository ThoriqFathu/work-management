<?php

namespace App\Services\WorkSession;

use App\Models\WorkRequest;

class SessionCalculatorService
{
    public function totalMinutes(
        WorkRequest $workRequest
    ): int {

        return (int) $workRequest
            ->workSessions()
            ->sum('durasi_menit');

    }

    public function totalHours(
        WorkRequest $workRequest
    ): string {

        $minutes = $this->totalMinutes($workRequest);
        // dd($minutes);
        $hours = intdiv($minutes, 60);

        $remain = $minutes % 60;

        return "{$hours} Jam {$remain} Menit";
    }
}
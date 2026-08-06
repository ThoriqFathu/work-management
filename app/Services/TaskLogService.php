<?php

namespace App\Services;

use App\Models\TaskLog;
use App\Models\WorkRequest;

class TaskLogService
{
    public function add(
        WorkRequest $workRequest,
        string $aktivitas,
        int $durasiMenit = 0,
        ?string $startedAt = null,
        ?string $endedAt = null
    ): TaskLog {

        return TaskLog::create([
            'work_request_id' => $workRequest->id,
            'user_id'         => auth()->id(),
            'aktivitas'       => $aktivitas,
            'durasi_menit'    => $durasiMenit,
            'started_at'      => $startedAt,
            'ended_at'        => $endedAt,
        ]);
    }
}
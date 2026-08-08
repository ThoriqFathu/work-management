<?php

namespace App\Services\WorkSession;

use App\Models\WorkSession;
use App\Services\ActivityLog\ActivityLogService;
use App\Services\Telegram\TelegramWorkSessionNotifier;
use Carbon\Carbon;

class StopWorkSessionService
{
    public function __construct(
        protected ActivityLogService $activityLogService,
        protected TelegramWorkSessionNotifier $telegramNotifier,
    ) {
    }

    public function execute(
        WorkSession $workSession
    ): WorkSession {

        $endedAt = Carbon::now();

        $duration = $workSession
            ->started_at
            ->diffInMinutes($endedAt);

        $workSession->update([
            'ended_at' => $endedAt,
            'durasi_menit' => $duration,
        ]);

        $workSession->refresh();

        $this->activityLogService->log(
            subject: $workSession,
            action: 'session_stopped',
            description: 'Mengakhiri sesi kerja',
            new: [
                'started_at' => $workSession->started_at,
                'ended_at' => $workSession->ended_at,
                'durasi_menit' => $workSession->durasi_menit,
            ]
        );

        $this->telegramNotifier->stopped(
            session: $workSession,
        );

        return $workSession;
    }
}
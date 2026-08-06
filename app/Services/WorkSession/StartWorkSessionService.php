<?php

namespace App\Services\WorkSession;

use App\Models\User;
use App\Models\WorkRequest;
use App\Models\WorkSession;
use App\Services\ActivityLog\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class StartWorkSessionService
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {
    }
    public function execute(
        WorkRequest $workRequest,
        User $user,
        ?string $catatan = null
    ): WorkSession {

        // Cek apakah user masih memiliki session aktif
        $activeSession = WorkSession::query()
            ->where('user_id', $user->id)
            ->whereNull('ended_at')
            ->first();

        if ($activeSession) {

            throw ValidationException::withMessages([
                'session' => 'Masih ada Work Session yang belum diselesaikan.',
            ]);

        }

        $session = WorkSession::create([

            'work_request_id' => $workRequest->id,

            'user_id' => $user->id,

            'started_at' => Carbon::now(),

            'catatan' => $catatan,

        ]);
        $this->activityLogService->log(
            subject: $session,
            action: 'session_started',
            description: 'Memulai sesi kerja'
        );
        return $session;

    }
}
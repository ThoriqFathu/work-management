<?php

namespace App\Services\WorkActivity;

use App\Models\User;
use App\Models\WorkActivity;
use App\Services\ActivityLog\ActivityLogService;

class CreateWorkActivityService
{
    public function __construct(
        protected ActivityLogService $activityLogService,
    ) {
    }

    public function execute(
        User $user,
        string $tipe,
        int $durasiMenit,
        string $ringkasan,
        int $unitKerjaId,
        ?int $requesterUnitId = null,
        ?string $channel = null,
    ): WorkActivity {
        $activity = WorkActivity::create([
            'user_id' => $user->id,
            'unit_kerja_id' => $unitKerjaId,
            'requester_unit_id' => $requesterUnitId,
            'tipe' => $tipe,
            'channel' => $channel,
            'durasi_menit' => $durasiMenit,
            'ringkasan' => $ringkasan,
        ]);

        // $this->activityLogService->log(
        //     subject: $activity,
        //     action: 'created',
        //     description: 'Mencatat aktivitas kerja spontan',
        //     new: [
        //         'tipe' => $activity->tipe,
        //         'channel' => $activity->channel,
        //         'durasi_menit' => $activity->durasi_menit,
        //         'ringkasan' => $activity->ringkasan,
        //     ],
        // );

        return $activity;
    }
}
<?php

namespace App\Services\ActivityLog;

use App\Models\WorkRequest;
use Illuminate\Support\Collection;

class GetActivityTimelineService
{
    public function execute(
        WorkRequest $workRequest
    ): Collection {

        $workRequest->loadMissing([

            'activityLogs.user',

            'workSessions.activityLogs.user',

            'workSessions.outputs.activityLogs.user',

        ]);

        $timeline = collect();

        /*
        |--------------------------------------------------------------------------
        | Work Request
        |--------------------------------------------------------------------------
        */

        $timeline = $timeline->merge(
            $workRequest->activityLogs
        );

        /*
        |--------------------------------------------------------------------------
        | Work Session
        |--------------------------------------------------------------------------
        */

        foreach ($workRequest->workSessions as $session) {

            $timeline = $timeline->merge(
                $session->activityLogs
            );

            /*
            |--------------------------------------------------------------------------
            | Output
            |--------------------------------------------------------------------------
            */

            foreach ($session->outputs as $output) {

                $timeline = $timeline->merge(
                    $output->activityLogs
                );

            }

        }

        return $timeline
            ->sortByDesc('created_at')
            ->values();
    }
}
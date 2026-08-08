<?php

namespace App\Services\ActivityLog;

use App\Models\WorkRequest;
use Illuminate\Support\Collection;

class GetActivityTimelineService
{
    public function __construct(
    protected ActivityLogFormatter $formatter,
    ) {
    }

    public function execute(
        WorkRequest $workRequest
    ): Collection {

        $workRequest->loadMissing([

            'activityLogs.user',

            'workSessions.activityLogs.user',

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

            $session->outputs()
            ->withTrashed()
            ->with('activityLogs.user')
            ->get()
            ->each(function ($output) use (&$timeline) {

                $timeline = $timeline->merge(
                    $output->activityLogs
                );

            });

        }

        return $timeline
            ->sortByDesc('created_at')
            ->values()
            ->map(
                fn ($activity) => $this->formatter->format($activity)
            );
    }
}
<?php

namespace App\Services;

use App\Models\WorkRequest;

class DashboardService
{
    public function getData(): array
    {
        return [
            'totalTask' => WorkRequest::count(),

            'progressTask' => WorkRequest::whereHas('status', function ($q) {
                $q->where('nama', 'Progress');
            })->count(),

            'waitingTask' => WorkRequest::whereHas('status', function ($q) {
                $q->where('nama', 'Waiting');
            })->count(),

            'doneTask' => WorkRequest::whereHas('status', function ($q) {
                $q->where('nama', 'Done');
            })->count(),

            'latestTask' => WorkRequest::latest()
                ->take(10)
                ->get(),
        ];
    }
}
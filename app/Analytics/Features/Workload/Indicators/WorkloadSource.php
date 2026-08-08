<?php

namespace App\Analytics\Features\Workload\Indicators;

use App\Analytics\Features\Workload\DTO\WorkloadFilter;
use App\Models\WorkActivity;
use App\Models\WorkSession;

class WorkloadSource
{
    public function calculate(
        WorkloadFilter $filter
    ): array {
        $startDate = $filter->startDate->copy()->startOfDay();
        $endDate = $filter->endDate->copy()->endOfDay();

        $workSession = WorkSession::query()
            ->whereBetween('started_at', [
                $startDate,
                $endDate,
            ])
            ->when(
                $filter->userId,
                fn ($query) => $query->where(
                    'user_id',
                    $filter->userId
                )
            )
            ->sum('durasi_menit');

        $workActivity = WorkActivity::query()
            ->whereBetween('created_at', [
                $startDate,
                $endDate,
            ])
            ->when(
                $filter->userId,
                fn ($query) => $query->where(
                    'user_id',
                    $filter->userId
                )
            )
            ->sum('durasi_menit');

        return [
            'categories' => [
                'Work Session',
                'Aktivitas Spontan',
            ],

            'series' => [
                [
                    'name' => 'Durasi',
                    'data' => [
                        (int) $workSession,
                        (int) $workActivity,
                    ],
                ],
            ],

            'work_session_menit' => (int) $workSession,
            'work_activity_menit' => (int) $workActivity,

            'total_menit' =>
                (int) $workSession +
                (int) $workActivity,
        ];
    }
}
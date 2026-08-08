<?php

namespace App\Analytics\Features\Workload\Indicators;

use App\Analytics\Features\Workload\DTO\WorkloadFilter;
use App\Models\WorkActivity;
use App\Models\WorkSession;
use Carbon\CarbonPeriod;

class WorkloadTrend
{
    public function calculate(
        WorkloadFilter $filter
    ): array {
        $startDate = $filter->startDate->copy()->startOfDay();
        $endDate = $filter->endDate->copy()->endOfDay();

        $sessions = WorkSession::query()
            ->selectRaw('
                DATE(started_at) as tanggal,
                SUM(durasi_menit) as durasi_menit
            ')
            ->whereBetween('started_at', [
                $startDate,
                $endDate,
            ])
            ->when(
                $filter->unitKerjaId,
                fn ($query) => $query->whereHas(
                    'workRequest',
                    fn ($query) => $query->where(
                        'unit_kerja_id',
                        $filter->unitKerjaId
                    )
                )
            )
            ->when(
                $filter->userId,
                fn ($query) => $query->where(
                    'user_id',
                    $filter->userId
                )
            )
            ->groupByRaw('DATE(started_at)')
            ->pluck('durasi_menit', 'tanggal');


        $activities = WorkActivity::query()
            ->selectRaw('
                DATE(created_at) as tanggal,
                SUM(durasi_menit) as durasi_menit
            ')
            ->whereBetween('created_at', [
                $startDate,
                $endDate,
            ])
            ->when(
                $filter->unitKerjaId,
                fn ($query) => $query->where(
                    'unit_kerja_id',
                    $filter->unitKerjaId
                )
            )
            ->when(
                $filter->userId,
                fn ($query) => $query->where(
                    'user_id',
                    $filter->userId
                )
            )
            ->groupByRaw('DATE(created_at)')
            ->pluck('durasi_menit', 'tanggal');


        $categories = [];

        $workSession = [];

        $workActivity = [];

        $total = [];


        $period = CarbonPeriod::create(
            $startDate->copy()->startOfDay(),
            $endDate->copy()->startOfDay()
        );


        foreach ($period as $date) {

            $tanggal = $date->format('Y-m-d');

            $sessionMinutes = (int) (
                $sessions[$tanggal] ?? 0
            );

            $activityMinutes = (int) (
                $activities[$tanggal] ?? 0
            );

            $totalMinutes =
                $sessionMinutes +
                $activityMinutes;


            $categories[] = $date->translatedFormat('d M');

            $workSession[] = $sessionMinutes;

            $workActivity[] = $activityMinutes;

            $total[] = $totalMinutes;
        }


        return [
            'categories' => $categories,

            'series' => [
                [
                    'name' => 'Work Session',
                    'data' => $workSession,
                ],

                [
                    'name' => 'Aktivitas Spontan',
                    'data' => $workActivity,
                ],

                [
                    'name' => 'Total Workload',
                    'data' => $total,
                ],
            ],
        ];
    }
}
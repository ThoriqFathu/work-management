<?php

namespace App\Analytics\Features\Workload\Indicators;

use App\Analytics\Features\Workload\DTO\WorkloadFilter;
use App\Models\WorkActivity;
use App\Models\WorkSession;

class TotalWorkload
{
    public function calculate(
        WorkloadFilter $filter
    ): int {
        $sessionMinutes = WorkSession::query()
            ->whereBetween('started_at', [
                $filter->startDate,
                $filter->endDate,
            ])
            ->when(
                $filter->unitKerjaId,
                function ($query) use ($filter) {
                    $query->whereHas(
                        'workRequest',
                        function ($query) use ($filter) {
                            $query->where(
                                'unit_kerja_id',
                                $filter->unitKerjaId
                            );
                        }
                    );
                }
            )
            ->when(
                $filter->userId,
                fn ($query) => $query->where(
                    'user_id',
                    $filter->userId
                )
            )
            ->sum('durasi_menit');


        $activityMinutes = WorkActivity::query()
            ->whereBetween('created_at', [
                $filter->startDate,
                $filter->endDate,
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
            ->when(
                $filter->requesterUnitId,
                fn ($query) => $query->where(
                    'requester_unit_id',
                    $filter->requesterUnitId
                )
            )
            ->sum('durasi_menit');


        return (int) (
            $sessionMinutes + $activityMinutes
        );
    }
}
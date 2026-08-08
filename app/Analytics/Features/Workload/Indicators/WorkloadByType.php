<?php

namespace App\Analytics\Features\Workload\Indicators;

use App\Analytics\Features\Workload\DTO\WorkloadFilter;
use App\Models\WorkActivity;

class WorkloadByType
{
    public function calculate(
        WorkloadFilter $filter
    ): array {
        return WorkActivity::query()
            ->selectRaw('
                tipe,
                COUNT(*) as jumlah,
                SUM(durasi_menit) as durasi_menit
            ')
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
            ->groupBy('tipe')
            ->orderByDesc('durasi_menit')
            ->get()
            ->map(fn ($row) => [
                'tipe' => $row->tipe,
                'jumlah' => (int) $row->jumlah,
                'durasi_menit' => (int) $row->durasi_menit,
            ])
            ->values()
            ->all();
    }
}
<?php

namespace App\Analytics\Features\Workload\Results;

final class WorkloadResult
{
    public function __construct(
        public readonly int $totalWorkloadMinutes,

        // public readonly int $workSessionMinutes,

        // public readonly int $workActivityMinutes,

        public readonly array $workloadByType,

        public readonly array $workloadTrend,

        public readonly array $workloadSource,
    ) {
    }


    public function totalWorkloadHours(): float
    {
        return round(
            $this->totalWorkloadMinutes / 60,
            2
        );
    }
}
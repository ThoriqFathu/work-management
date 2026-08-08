<?php

namespace App\Analytics\Features\Workload\Managers;

use App\Analytics\Features\Workload\DTO\WorkloadFilter;
use App\Analytics\Features\Workload\Indicators\TotalWorkload;
use App\Analytics\Features\Workload\Indicators\WorkloadByType;
use App\Analytics\Features\Workload\Indicators\WorkloadSource;
use App\Analytics\Features\Workload\Indicators\WorkloadTrend;
use App\Analytics\Features\Workload\Results\WorkloadResult;

class WorkloadManager
{
    public function __construct(
        protected TotalWorkload $totalWorkload,


        protected WorkloadByType $workloadByType,

        protected WorkloadTrend $workloadTrend,

        protected WorkloadSource $workloadSource,
    ) {
    }


    public function calculate(
        WorkloadFilter $filter
    ): WorkloadResult {

        // $source = $this->workloadBySource
        //     ->calculate($filter);

        $byType = $this->workloadByType
            ->calculate($filter);

        $trend = $this->workloadTrend
            ->calculate($filter);
        
        $source = $this->workloadSource->calculate($filter);


        return new WorkloadResult(

            totalWorkloadMinutes:
                $this->totalWorkload->calculate(
                    $filter
                ),

            // workSessionMinutes:
            //     $source['work_session'],

            // workActivityMinutes:
            //     $source['work_activity'],

            workloadByType:
                $byType,

            workloadTrend:
                $trend,

            workloadSource:
                $source,

        );
    }
}
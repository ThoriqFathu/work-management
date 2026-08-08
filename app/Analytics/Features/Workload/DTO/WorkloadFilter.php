<?php

namespace App\Analytics\Features\Workload\DTO;

use Carbon\Carbon;

final class WorkloadFilter
{
    public function __construct(
        public readonly Carbon $startDate,
        public readonly Carbon $endDate,
        public readonly ?int $unitKerjaId = null,
        public readonly ?int $userId = null,
        public readonly ?int $requesterUnitId = null,
    ) {
    }
}
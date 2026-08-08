<?php

namespace App\Services\ActivityLog\Contracts;

use App\Models\ActivityLog;

interface ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array;
}
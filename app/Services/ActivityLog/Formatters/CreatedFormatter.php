<?php

namespace App\Services\ActivityLog\Formatters;

use App\Models\ActivityLog;
use App\Services\ActivityLog\Contracts\ActivityFormatterInterface;

class CreatedFormatter implements ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array {

        return [

            'title' => 'Membuat Work Request',

            'icon' => 'plus',

            'color' => 'green',

            'details' => [],

        ];

    }
}
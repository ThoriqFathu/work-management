<?php

namespace App\Services\ActivityLog\Formatters;

use App\Models\ActivityLog;
use App\Services\ActivityLog\Contracts\ActivityFormatterInterface;

class SessionStartedFormatter implements ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array {

        return [

            'title' => 'Memulai Sesi Kerja',

            'icon' => 'play',

            'color' => 'indigo',

            'details' => [],

        ];

    }
}
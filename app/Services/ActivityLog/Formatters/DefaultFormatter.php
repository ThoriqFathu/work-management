<?php

namespace App\Services\ActivityLog\Formatters;

use App\Models\ActivityLog;
use App\Services\ActivityLog\Contracts\ActivityFormatterInterface;

class DefaultFormatter implements ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array {

        return [

            'title' => $activity->deskripsi,

            'icon' => 'circle',

            'color' => 'gray',

            'details' => [],

        ];

    }
}
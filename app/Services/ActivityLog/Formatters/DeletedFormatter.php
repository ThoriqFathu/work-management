<?php

namespace App\Services\ActivityLog\Formatters;

use App\Models\ActivityLog;
use App\Services\ActivityLog\Contracts\ActivityFormatterInterface;

class DeletedFormatter implements ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array {

        return [

            'title' => 'Menghapus Work Request',

            'icon' => 'trash',

            'color' => 'red',

            'details' => [],

        ];

    }
}
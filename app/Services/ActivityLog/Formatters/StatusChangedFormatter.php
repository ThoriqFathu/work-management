<?php

namespace App\Services\ActivityLog\Formatters;

use App\Models\ActivityLog;
use App\Models\Status;
use App\Services\ActivityLog\Contracts\ActivityFormatterInterface;

class StatusChangedFormatter implements ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array {

        $old = Status::find(
            data_get($activity->data_lama, 'status_id')
        );

        $new = Status::find(
            data_get($activity->data_baru, 'status_id')
        );

        return [

            'title' => 'Status Berubah',

            'icon' => 'refresh',

            'color' => 'blue',

            'details' => [

                [

                    'label' => 'Status',

                    'before' => $old?->nama,

                    'after' => $new?->nama,

                ],

            ],

        ];

    }
}
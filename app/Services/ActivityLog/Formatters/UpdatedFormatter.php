<?php

namespace App\Services\ActivityLog\Formatters;

use App\Models\ActivityLog;
use App\Services\ActivityLog\Contracts\ActivityFormatterInterface;

class UpdatedFormatter implements ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array {

        $details = [];

        foreach ($activity->data_baru ?? [] as $field => $value) {

            $old = data_get(
                $activity->data_lama,
                $field
            );

            if ($old == $value) {
                continue;
            }

            $details[] = [

                'label' => ucfirst(
                    str_replace('_', ' ', $field)
                ),

                'before' => $old,

                'after' => $value,

            ];

        }

        return [

            'title' => 'Mengubah Work Request',

            'icon' => 'pencil',

            'color' => 'yellow',

            'details' => $details,

        ];

    }
}
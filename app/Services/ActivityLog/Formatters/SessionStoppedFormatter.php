<?php

namespace App\Services\ActivityLog\Formatters;

use App\Models\ActivityLog;
use App\Services\ActivityLog\Contracts\ActivityFormatterInterface;
use Carbon\Carbon;

class SessionStoppedFormatter implements ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array {

        $started = data_get($activity->data_baru, 'started_at');
        $ended = data_get($activity->data_baru, 'ended_at');

        return [

            'title' => 'Mengakhiri Sesi Kerja',

            'icon' => 'stop',

            'color' => 'purple',

            'details' => [

               [
                    'label' => 'Mulai',
                    'value' => $started
                        ? Carbon::parse($started)
                            ->timezone('Asia/Jakarta')
                            ->format('d M Y H:i')
                        : '-',
                ],

                [
                    'label' => 'Selesai',
                    'value' => $ended
                        ? Carbon::parse($ended)
                            ->timezone('Asia/Jakarta')
                            ->format('d M Y H:i')
                        : '-',
                ],

                [
                    'label' => 'Durasi',
                    'value' => data_get($activity->data_baru, 'durasi_menit') . ' menit',
                ],

            ],

        ];

    }
}
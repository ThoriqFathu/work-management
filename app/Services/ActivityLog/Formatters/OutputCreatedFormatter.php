<?php

namespace App\Services\ActivityLog\Formatters;

use App\Models\ActivityLog;
use App\Services\ActivityLog\Contracts\ActivityFormatterInterface;

class OutputCreatedFormatter implements ActivityFormatterInterface
{
    public function format(
        ActivityLog $activity
    ): array {

        return [

            'title' => 'Menambahkan Output',

            'icon' => 'paperclip',

            'color' => 'emerald',

            'details' => $this->details($activity),

        ];

    }

    protected function details(
        ActivityLog $activity
    ): array {

        $data = $activity->data_baru ?? [];

        $details = [

            [
                'label' => 'Nama',
                'value' => $data['nama'] ?? '-',
            ],

            [
                'label' => 'Tipe',
                'value' => ucfirst($data['tipe'] ?? '-'),
            ],

        ];

        switch ($data['tipe'] ?? null) {

            case 'file':

                $details[] = [
                    'label' => 'File',
                    'value' => $data['original_filename'] ?? '-',
                ];

                if (!empty($data['human_size'])) {

                    $details[] = [
                        'label' => 'Ukuran',
                        'value' => $data['human_size'],
                    ];

                }

                break;

            case 'link':

                $details[] = [
                    'label' => 'URL',
                    'value' => $data['url'] ?? '-',
                ];

                break;

            case 'text':

                $details[] = [
                    'label' => 'Isi',
                    'value' => $data['content'] ?? '-',
                ];

                break;

        }

        if (!empty($data['catatan'])) {

            $details[] = [

                'label' => 'Catatan',

                'value' => $data['catatan'],

            ];

        }

        return $details;
    }
}
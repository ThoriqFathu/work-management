<?php

namespace App\Services\WorkSessionOutput;

use App\Models\WorkSession;
use App\Models\WorkSessionOutput;
use App\Services\ActivityLog\ActivityLogService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreWorkSessionOutputService
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {
    }
    public function execute(
        WorkSession $session,
        array $data
    ): WorkSessionOutput {

        $value = $data['value'] ?? null;

        if (
            $data['tipe'] === 'file'
            && isset($data['file'])
            && $data['file'] instanceof UploadedFile
        ) {

            $value = $data['file']->store(
                'work-session-output',
                'public'
            );

        }

        $urutan = $session
            ->outputs()
            ->max('urutan') ?? 0;

        $output = $session
            ->outputs()
            ->create([

                'tipe' => $data['tipe'],

                'nama' => $data['nama'],

                'value' => $value,

                'catatan' => $data['catatan'] ?? null,

                'urutan' => $urutan + 1,

            ]);
        $this->activityLogService->log(
            subject: $output,
            action: 'output_created',
            description: 'Menambahkan output',
            new: [
                'nama' => $output->nama,
                'tipe' => $output->tipe,
                'value' => $output->value,
                'catatan' => $output->catatan,
            ]
        );
        return $output;

    }
}
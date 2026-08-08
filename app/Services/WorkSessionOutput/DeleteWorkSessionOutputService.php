<?php

namespace App\Services\WorkSessionOutput;

use App\Models\WorkSessionOutput;
use App\Services\ActivityLog\ActivityLogService;
use Illuminate\Support\Facades\Storage;

class DeleteWorkSessionOutputService
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {
    }

    public function execute(
        WorkSessionOutput $output
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Hapus file fisik
        |--------------------------------------------------------------------------
        */

        if (
            $output->isFile()
            && $output->storage_path
        ) {

            Storage::disk('public')
                ->delete($output->storage_path);

        }

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        $this->activityLogService->log(

            subject: $output,

            action: 'output_deleted',

            description: 'Menghapus output',

            old: [

                'nama' => $output->nama,

                'tipe' => $output->tipe,

                'url' => $output->url,

                'original_filename' => $output->original_filename,

                'size' => $output->human_size,

                'content' => $output->content,

                'catatan' => $output->catatan,

            ]

        );

        /*
        |--------------------------------------------------------------------------
        | Soft Delete
        |--------------------------------------------------------------------------
        */

        $output->delete();

    }
}
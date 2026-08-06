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

        if (
            $output->tipe === 'file'
            && $output->value
        ) {

            Storage::disk('public')
                ->delete($output->value);

        }
        $this->activityLogService->log(
            subject: $output,
            action: 'output_deleted',
            description: "Menghapus output {$output->nama}"
        );
        $output->delete();

    }
}
<?php

namespace App\Services\WorkSessionOutput;

use App\Models\WorkSession;
use App\Models\WorkSessionOutput;
use App\Services\ActivityLog\ActivityLogService;
use Illuminate\Http\UploadedFile;

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
        // dd($data);
        $attributes = [

            'tipe' => $data['tipe'],

            'nama' => $data['nama'],

            'catatan' => $data['catatan'] ?? null,

            'urutan' => ($session->outputs()->max('urutan') ?? 0) + 1,

        ];

        match ($data['tipe']) {

            'file' => $this->fillFileAttributes(
                $attributes,
                $data['file']
            ),

            'link' => $this->fillLinkAttributes(
                $attributes,
                $data
            ),

            'text' => $this->fillTextAttributes(
                $attributes,
                $data
            ),

            default => throw new \InvalidArgumentException(
                'Tipe output tidak valid.'
            ),

        };

        $output = $session
            ->outputs()
            ->create($attributes);

        $this->activityLogService->log(

            subject: $output,

            action: 'output_created',

            description: 'Menambahkan output',

            new: [

                'nama' => $output->nama,

                'tipe' => $output->tipe,

                'url' => $output->url,

                'original_filename' => $output->original_filename,

                'size' => $output->human_size,

                'content' => $output->content,

                'catatan' => $output->catatan,

            ]

        );

        return $output;
    }

    private function fillFileAttributes(
        array &$attributes,
        UploadedFile $file
    ): void {

        $attributes['storage_path'] = $file->store(
            'work-session-output',
            'public'
        );

        $attributes['original_filename'] = $file->getClientOriginalName();

        $attributes['mime_type'] = $file->getMimeType();

        $attributes['size'] = $file->getSize();
    }

    private function fillLinkAttributes(
        array &$attributes,
        array $data
    ): void {

        $attributes['url'] = $data['url'];

    }

    private function fillTextAttributes(
        array &$attributes,
        array $data
    ): void {

        $attributes['content'] = $data['content'];

    }
}
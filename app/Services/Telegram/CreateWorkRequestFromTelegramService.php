<?php

namespace App\Services\Telegram;

use App\Models\TelegramUser;
use App\Models\WorkRequest;
use App\Services\WorkRequestService;
use Illuminate\Support\Facades\DB;

class CreateWorkRequestFromTelegramService
{
    public function __construct(
        protected ResolveUnitKerjaService $resolveUnitKerja,
        protected ResolveRequesterUnitService $resolveRequesterUnit,
        protected WorkRequestService $workRequestService,
    ) {
    }

    public function execute(
        array $parsed,
        TelegramUser $telegramUser,
    ): array {
        return DB::transaction(function () use (
            $parsed,
            $telegramUser
        ) {

            $unitKerja = $this->resolveUnitKerja->execute(
                $parsed['unit_kerja']
            );

            $created = [];

            foreach ($parsed['requests'] as $request) {

                $requester = $this->resolveRequesterUnit->execute(
                    $request['requester']
                );

                $workRequest = $this->workRequestService->create(
                    [
                        'judul' => $request['judul'],
                        'unit_kerja_id' => $unitKerja->id,
                        'requester_unit_id' => $requester->id,
                        'source' => 'internal',
                    ],
                    $telegramUser->user,
                );

                $created[] = $workRequest;
            }

            return $created;
        });
    }
}
<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;
use App\Services\WorkSession\InfoWorkSessionService;

class InfoWorkSessionCommand implements TelegramCommand
{
    public function __construct(
        protected InfoWorkSessionService $service,
    ) {
    }

    public function name(): string
    {
        return '/info-ws';
    }

    public function description(): string
    {
        return 'Menampilkan Work Session yang sedang aktif.';
    }

    public function usage(): string
    {
        return '/info-ws';
    }

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string {
        return $this->service->execute();
    }
}
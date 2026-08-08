<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;
use App\Services\Telegram\InfoRequesterService;

class InfoRequesterCommand implements TelegramCommand
{
    public function __construct(
        protected InfoRequesterService $service,
    ) {
    }

    public function name(): string
    {
        return '/info-requester';
    }

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string {
        return $this->service->execute();
    }
}
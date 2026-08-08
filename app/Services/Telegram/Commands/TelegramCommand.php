<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;

interface TelegramCommand
{
    public function name(): string;

    public function description(): string;

    public function usage(): string;

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string;
}
<?php

namespace App\Services\Telegram;

use App\Models\TelegramUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResolveTelegramUserService
{
    public function execute(int|string $telegramUserId): TelegramUser
    {
        $telegramUser = TelegramUser::query()
            ->with('user')
            ->where('telegram_user_id', $telegramUserId)
            ->first();

        if (! $telegramUser) {
            throw new ModelNotFoundException(
                "Telegram user '{$telegramUserId}' belum terdaftar."
            );
        }

        if (! $telegramUser->user) {
            throw new ModelNotFoundException(
                "Telegram user '{$telegramUserId}' belum memiliki mapping User Laravel."
            );
        }

        return $telegramUser;
    }
}
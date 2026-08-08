<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;

class TelegramBotService
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token');
    }

    public function getMe(): array
    {
        return Http::get(
            "https://api.telegram.org/bot{$this->token}/getMe"
        )->throw()->json();
    }
    public function sendMessage(
        int|string $chatId,
        string $text,
    ): array {

        return Http::post(
            "https://api.telegram.org/bot{$this->token}/sendMessage",
            [
                'chat_id' => $chatId,
                'text' => $text,
            ]
        )->throw()->json();
    }
}
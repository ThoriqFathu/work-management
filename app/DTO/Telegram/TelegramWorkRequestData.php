<?php

namespace App\DTO\Telegram;

class TelegramWorkRequestData
{
    public function __construct(
        public readonly string $judul,
        public readonly string $requester,
        public readonly ?string $priority = null,
    ) {
    }
}
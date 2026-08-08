<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;
use App\Services\Telegram\CreateWorkRequestFromTelegramService;
use App\Services\Telegram\TelegramRequestParser;

class CreateRequestCommand implements TelegramCommand
{
    public function __construct(
        protected TelegramRequestParser $parser,
        protected CreateWorkRequestFromTelegramService $service,
    ) {
    }

    public function name(): string
    {
        return '/req:';
    }

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string {
        $parsed = $this->parser->parse($text);

        $workRequests = $this->service->execute(
            $parsed,
            $telegramUser,
        );

        $lines = [
            '✅ Work Request berhasil dibuat:',
            '',
        ];

        foreach ($workRequests as $workRequest) {
            $lines[] =
                "{$workRequest->kode} - {$workRequest->judul}";
        }

        return implode("\n", $lines);
    }
}
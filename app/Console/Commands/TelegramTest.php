<?php

namespace App\Console\Commands;

use App\Services\Telegram\TelegramBotService;
use Illuminate\Console\Command;

class TelegramTest extends Command
{
    protected $signature = 'telegram:test';

    protected $description = 'Test koneksi Telegram Bot';

    public function handle(
        TelegramBotService $telegram
    ): int {

        $result = $telegram->getMe();

        if (! ($result['ok'] ?? false)) {

            $this->error(
                'Telegram Bot gagal.'
            );

            return self::FAILURE;
        }

        $bot = $result['result'];

        $this->info(
            "Bot aktif: @{$bot['username']}"
        );

        return self::SUCCESS;
    }
}
<?php

namespace App\Console\Commands;

use App\Services\Telegram\TelegramBotService;
use Illuminate\Console\Command;

class TelegramSendTest extends Command
{
    protected $signature = 'telegram:send-test
    {--chat-id= : ID chat Telegram}';

    protected $description = 'Test mengirim pesan ke Telegram';

    public function handle(
        TelegramBotService $telegram
    ): int {

        $chatId = $this->option('chat-id');

        $telegram->sendMessage(
            $chatId,
            "🤖 Test berhasil.\n\n"
            . "Bot @reqstarcode_bot sudah bisa mengirim pesan."
        );

        $this->info(
            'Pesan berhasil dikirim ke Telegram.'
        );

        return self::SUCCESS;
    }
}
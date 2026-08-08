<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;

class HelpCommand implements TelegramCommand
{
    public function __construct(
        protected TelegramCommandRegistry $registry,
    ) {
    }

    public function name(): string
    {
        return '/help';
    }

    public function description(): string
    {
        return 'Menampilkan daftar perintah yang tersedia.';
    }

    public function usage(): string
    {
        return '/help';
    }

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string {

        $lines = [
            '🤖 WORK MANAGEMENT BOT',
            '',
            'Perintah yang tersedia:',
            '',
        ];

        foreach ($this->registry->all() as $command) {

            $lines[] = "🔹 {$command->name()}";
            $lines[] = "   {$command->description()}";
            $lines[] = "   Contoh: {$command->usage()}";
            $lines[] = '';
        }

        $lines[] = '💡 Gunakan /help kapan saja untuk melihat bantuan.';

        return implode("\n", $lines);
    }
}
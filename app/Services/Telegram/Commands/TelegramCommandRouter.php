<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;

class TelegramCommandRouter
{
    /**
     * @param iterable<TelegramCommand> $commands
     */
    public function __construct(
        protected iterable $commands,
    ) {
    }

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string {
        $text = trim($text);

        foreach ($this->commands as $command) {
            if ($this->matches($command->name(), $text)) {
                return $command->handle(
                    $text,
                    $telegramUser,
                );
            }
        }

        return null;
    }

    protected function matches(
        string $command,
        string $text,
    ): bool {
        $command = strtolower($command);
        $text = strtolower($text);

        if (str_ends_with($command, ':')) {
            return str_starts_with(
                $text,
                $command
            );
        }

        return $text === $command;
    }
}
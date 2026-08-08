<?php

namespace App\Services\Telegram\Commands;

class TelegramCommandRegistry
{
    /**
     * @param iterable<TelegramCommand> $commands
     */
    public function __construct(
        protected iterable $commands,
    ) {
    }

    /**
     * @return array<TelegramCommand>
     */
    public function all(): array
    {
        return is_array($this->commands)
            ? $this->commands
            : iterator_to_array($this->commands);
    }
}
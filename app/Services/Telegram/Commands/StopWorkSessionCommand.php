<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;
use App\Models\WorkSession;
use App\Services\WorkSession\StopWorkSessionService;

class StopWorkSessionCommand implements TelegramCommand
{
    public function __construct(
        protected StopWorkSessionService $service,
    ) {
    }

    public function name(): string
    {
        return '/stop-ws';
    }

    public function description(): string
    {
        return 'Menghentikan Work Session aktif milik Anda.';
    }

    public function usage(): string
    {
        return '/stop-ws';
    }

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string {
        $session = WorkSession::query()
            ->where('user_id', $telegramUser->user_id)
            ->whereNull('ended_at')
            ->latest('started_at')
            ->first();

        if (! $session) {
            return 'ℹ️ Tidak ada Work Session aktif.';
        }

        $this->service->execute($session);

        return null;
    }
}
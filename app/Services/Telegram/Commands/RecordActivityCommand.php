<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;
use App\Services\WorkActivity\CreateWorkActivityFromTelegramService;
use Throwable;

class RecordActivityCommand implements TelegramCommand
{
    public function __construct(
        protected CreateWorkActivityFromTelegramService $service,
    ) {
    }

    public function name(): string
    {
        return '/act:';
    }

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string {

        try {

            $activity = $this->service->execute(
                text: $text,
                telegramUser: $telegramUser,
            );

            return implode("\n", [
                '✅ Aktivitas berhasil dicatat.',
                '',
                ucfirst($activity->tipe),
                "Requester : " . (
                    $activity->requesterUnit?->nama ?? '-'
                ),
                "Media     : " . (
                    $this->formatChannel($activity->channel)
                ),
                "Durasi    : {$activity->durasi_menit} menit",
                '',
                $activity->ringkasan,
            ]);

        } catch (Throwable $e) {

            report($e);

            return '❌ Gagal mencatat aktivitas: '
                . $e->getMessage();
        }
    }

    protected function formatChannel(?string $channel): string
    {
        return match ($channel) {
            'phone' => 'Phone / Call',
            'whatsapp' => 'WhatsApp',
            'telegram' => 'Telegram',
            'onsite' => 'On-site',
            'remote' => 'Remote',
            default => '-',
        };
    }
}
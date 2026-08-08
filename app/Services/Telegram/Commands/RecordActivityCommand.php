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

    public function description(): string
    {
        return 'Mencatat aktivitas kerja spontan.';
    }

    public function usage(): string
        {
            return <<<TEXT
        /act:unit kerja | tipe | requester | media | durasi | ringkasan
        /act:RSUD Ketapang | support | Admin Poli | phone | 15 | Membantu user mengatasi printer
        TEXT;
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
                '🏢 Unit Kerja : ' . (
                    $activity->unitKerja?->nama ?? '-'
                ),
                '📌 Tipe       : ' . ucfirst($activity->tipe),
                '👤 Requester  : ' . (
                    $activity->requesterUnit?->nama ?? '-'
                ),
                '📞 Media      : ' . (
                    $this->formatChannel($activity->channel)
                ),
                '⏱️ Durasi     : ' . $this->formatDuration(
                    $activity->durasi_menit
                ),
                '',
                '📝 ' . $activity->ringkasan,
            ]);

        } catch (Throwable $e) {

            report($e);

            return '❌ Gagal mencatat aktivitas: '
                . $e->getMessage();
        }
    }

    protected function formatDuration(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0 && $remainingMinutes > 0) {
            return "{$hours} jam {$remainingMinutes} menit";
        }

        if ($hours > 0) {
            return "{$hours} jam";
        }

        return "{$remainingMinutes} menit";
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
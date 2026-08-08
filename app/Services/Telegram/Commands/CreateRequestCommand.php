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

     public function description(): string
    {
        return 'Membuat Work Request List baru.';
    }

    public function usage(): string
    {
        return "/req:Ketapang\n"
            . "- Judul Request | requester\n"
            . "- Monitoring Prediksi Pendapatan Klaim BPJS | Direktur\n"
            . "- Kunjungan Ralan | Rawat Jalan\n"
            . "- Kunjungan Ranap | Rawat Inap\n"
            . "- Kunjungan IGD | IT";
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
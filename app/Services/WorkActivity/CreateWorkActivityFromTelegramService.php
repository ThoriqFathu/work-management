<?php

namespace App\Services\WorkActivity;

use App\Models\TelegramUser;
use App\Models\WorkActivity;
use App\Services\Telegram\ResolveRequesterUnitService;

class CreateWorkActivityFromTelegramService
{
    public function __construct(
        protected CreateWorkActivityService $createWorkActivity,
        protected ResolveRequesterUnitService $resolveRequesterUnit,
    ) {
    }

    public function execute(
        string $text,
        TelegramUser $telegramUser,
    ): WorkActivity {

        $payload = $this->parse($text);

        $requesterUnitId = null;

        if ($payload['requester'] !== '-') {

            $requesterUnit = $this->resolveRequesterUnit->execute(
                $payload['requester']
            );

            $requesterUnitId = $requesterUnit->id;
        }

        return $this->createWorkActivity->execute(
            user: $telegramUser->user,
            tipe: $payload['tipe'],
            requesterUnitId: $requesterUnitId,
            channel: $payload['channel'],
            durasiMenit: $payload['durasi'],
            ringkasan: $payload['ringkasan'],
        );
    }

    protected function parse(string $text): array
    {
        $text = trim($text);

        $text = preg_replace(
            '/^\/act:/i',
            '',
            $text
        );

        $parts = array_map(
            'trim',
            explode('|', $text)
        );

        if (count($parts) !== 5) {

            throw new \InvalidArgumentException(
                'Format salah. Gunakan: '
                . '/act:tipe | requester | media | durasi | ringkasan'
            );
        }

        [
            $tipe,
            $requester,
            $channel,
            $durasi,
            $ringkasan,
        ] = $parts;

        $allowedTipe = [
            'support',
            'troubleshooting',
            'maintenance',
            'monitoring',
            'koordinasi',
            'meeting',
            'administrasi',
            'lainnya',
        ];

        if (! in_array(strtolower($tipe), $allowedTipe, true)) {

            throw new \InvalidArgumentException(
                "Tipe aktivitas '{$tipe}' tidak valid."
            );
        }

        $allowedChannel = [
            'phone',
            'whatsapp',
            'telegram',
            'onsite',
            'remote',
        ];

        if (
            $channel !== '-'
            && ! in_array(strtolower($channel), $allowedChannel, true)
        ) {

            throw new \InvalidArgumentException(
                "Media '{$channel}' tidak valid."
            );
        }

        if (! is_numeric($durasi) || (int) $durasi < 1) {

            throw new \InvalidArgumentException(
                'Durasi harus berupa angka menit.'
            );
        }

        if (blank($ringkasan)) {

            throw new \InvalidArgumentException(
                'Ringkasan aktivitas wajib diisi.'
            );
        }

        return [
            'tipe' => strtolower($tipe),
            'requester' => strtolower($requester),
            'channel' => strtolower($channel) === '-'
                ? null
                : strtolower($channel),
            'durasi' => (int) $durasi,
            'ringkasan' => $ringkasan,
        ];
    }
}
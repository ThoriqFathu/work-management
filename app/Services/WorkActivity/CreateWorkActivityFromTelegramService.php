<?php

namespace App\Services\WorkActivity;

use App\Models\TelegramUser;
use App\Models\WorkActivity;
use App\Services\Telegram\ResolveRequesterUnitService;
use App\Services\WorkActivity\ResolveUnitKerjaService;

class CreateWorkActivityFromTelegramService
{
    public function __construct(
        protected CreateWorkActivityService $createWorkActivity,
        protected ResolveRequesterUnitService $resolveRequesterUnit,
        protected ResolveUnitKerjaService $resolveUnitKerja,
    ) {
    }

    public function execute(
        string $text,
        TelegramUser $telegramUser,
    ): WorkActivity {

        $payload = $this->parse($text);

        /*
        |--------------------------------------------------------------------------
        | Resolve Unit Kerja
        |--------------------------------------------------------------------------
        */

        $unitKerja = $this->resolveUnitKerja->execute(
            $payload['unit_kerja']
        );

        /*
        |--------------------------------------------------------------------------
        | Resolve Requester
        |--------------------------------------------------------------------------
        */

        $requesterUnitId = null;

        if ($payload['requester'] !== '-') {

            $requesterUnit = $this->resolveRequesterUnit->execute(
                $payload['requester']
            );

            $requesterUnitId = $requesterUnit->id;
        }

        /*
        |--------------------------------------------------------------------------
        | Create Activity
        |--------------------------------------------------------------------------
        */

        return $this->createWorkActivity->execute(
            user: $telegramUser->user,
            tipe: $payload['tipe'],
            durasiMenit: $payload['durasi'],
            ringkasan: $payload['ringkasan'],
            unitKerjaId: $unitKerja->id,
            requesterUnitId: $requesterUnitId,
            channel: $payload['channel'],
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

        /*
        |--------------------------------------------------------------------------
        | Format
        |--------------------------------------------------------------------------
        |
        | /act:unit kerja | tipe | requester | media | durasi | ringkasan
        |
        */

        if (count($parts) !== 6) {

            throw new \InvalidArgumentException(
                'Format salah. Gunakan: '
                . '/act:unit kerja | tipe | requester | media | durasi | ringkasan'
            );
        }

        [
            $unitKerja,
            $tipe,
            $requester,
            $channel,
            $durasi,
            $ringkasan,
        ] = $parts;

        /*
        |--------------------------------------------------------------------------
        | Validasi Unit Kerja
        |--------------------------------------------------------------------------
        */

        if (blank($unitKerja)) {

            throw new \InvalidArgumentException(
                'Unit kerja wajib diisi.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi Tipe
        |--------------------------------------------------------------------------
        */

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

        if (! in_array(
            strtolower($tipe),
            $allowedTipe,
            true
        )) {

            throw new \InvalidArgumentException(
                "Tipe aktivitas '{$tipe}' tidak valid."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi Channel
        |--------------------------------------------------------------------------
        */

        $allowedChannel = [
            'phone',
            'whatsapp',
            'telegram',
            'onsite',
            'remote',
        ];

        if (
            $channel !== '-'
            && ! in_array(
                strtolower($channel),
                $allowedChannel,
                true
            )
        ) {

            throw new \InvalidArgumentException(
                "Media '{$channel}' tidak valid."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi Durasi
        |--------------------------------------------------------------------------
        */

        if (
            ! is_numeric($durasi)
            || (int) $durasi < 1
        ) {

            throw new \InvalidArgumentException(
                'Durasi harus berupa angka menit.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi Ringkasan
        |--------------------------------------------------------------------------
        */

        if (blank($ringkasan)) {

            throw new \InvalidArgumentException(
                'Ringkasan aktivitas wajib diisi.'
            );
        }

        return [
            'unit_kerja' => trim($unitKerja),

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
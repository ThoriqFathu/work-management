<?php

namespace App\Services\Telegram;

use InvalidArgumentException;

class TelegramRequestParser
{
    public function parse(string $message): array
    {
        $message = trim($message);

        if (! preg_match(
            '/^\/req:([a-zA-Z0-9_-]+)(?:@\w+)?(?:\s+|$)/i',
            $message,
            $matches,
            PREG_OFFSET_CAPTURE
        )) {
            throw new InvalidArgumentException(
                'Format command tidak valid. Gunakan /req:nama-unit.'
            );
        }

        $unitKerja = trim($matches[1][0]);

        /*
        |--------------------------------------------------------------------------
        | Ambil isi setelah command
        |--------------------------------------------------------------------------
        */

        $commandLength = strlen($matches[0][0]);

        $content = trim(
            substr($message, $commandLength)
        );

        if ($content === '') {
            throw new InvalidArgumentException(
                'Belum ada request yang dikirim.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Parse setiap baris
        |--------------------------------------------------------------------------
        */

        $lines = preg_split(
            '/\R/',
            $content,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $requests = [];

        foreach ($lines as $line) {
            $line = trim($line);

            if (! str_starts_with($line, '-')) {
                throw new InvalidArgumentException(
                    "Format tidak valid: {$line}"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Hilangkan tanda "-"
            |--------------------------------------------------------------------------
            */

            $line = trim(
                ltrim($line, '-')
            );

            $parts = array_map(
                'trim',
                explode('|', $line)
            );

            if (count($parts) < 2) {
                throw new InvalidArgumentException(
                    "Format request tidak valid: {$line}"
                );
            }

            $judul = $parts[0];
            $requester = $parts[1];
            $priority = $parts[2] ?? null;

            if ($judul === '') {
                throw new InvalidArgumentException(
                    'Judul request tidak boleh kosong.'
                );
            }

            if ($requester === '') {
                throw new InvalidArgumentException(
                    "Requester tidak boleh kosong: {$judul}"
                );
            }

            $requests[] = [
                'judul' => $judul,
                'requester' => $requester,
                'priority' => $priority ?: null,
            ];
        }

        return [
            'unit_kerja' => $unitKerja,
            'requests' => $requests,
        ];
    }
}
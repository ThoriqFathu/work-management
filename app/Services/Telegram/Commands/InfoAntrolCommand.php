<?php

namespace App\Services\Telegram\Commands;

use App\Models\TelegramUser;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InfoAntrolCommand implements TelegramCommand
{
    private const ENDPOINT = '/api/antrol/sep-tidak-ada-di-antrian';

    public function name(): string
    {
        return '/info-antrol';
    }

    public function description(): string
    {
        return 'Memicu pengecekan SEP Antrol RSUD dan RSIA.';
    }

    public function usage(): string
    {
        return '/info-antrol';
    }

    public function handle(
        string $text,
        TelegramUser $telegramUser,
    ): ?string {
        $targets = [
            'RSUD' => config('services.antrol.rsud'),
            'RSIA' => config('services.antrol.rsia'),
        ];

        $results = [];
        $requests = [];

        foreach ($targets as $name => $baseUrl) {
            if (empty($baseUrl)) {
                $results[$name] = '❌ URL belum dikonfigurasi';
                continue;
            }

            $requests[$name] = rtrim($baseUrl, '/')
                . self::ENDPOINT;
        }

        if (!empty($requests)) {
            try {
                $responses = Http::pool(function (Pool $pool) use ($requests) {
                    $pending = [];

                    foreach ($requests as $name => $url) {
                        $pending[$name] = $pool
                            ->as($name)
                            ->connectTimeout(3)
                            ->timeout(10)
                            ->post($url);
                    }

                    return $pending;
                });

                foreach ($requests as $name => $url) {
                    $response = $responses[$name] ?? null;

                    if ($response instanceof \Illuminate\Http\Client\Response) {
                        if ($response->status() === 204) {
                            $results[$name] = '✅ Trigger berhasil';
                        } else {
                            $results[$name] = '❌ HTTP ' . $response->status();

                            Log::warning('Info Antrol trigger gagal', [
                                'target' => $name,
                                'url' => $url,
                                'status' => $response->status(),
                                'body' => $response->body(),
                            ]);
                        }
                    } else {
                        $results[$name] = '❌ Tidak dapat terhubung';

                        Log::error('Info Antrol tidak mendapat response', [
                            'target' => $name,
                            'url' => $url,
                            'error' => $response instanceof \Throwable
                                ? $response->getMessage()
                                : 'Response tidak tersedia',
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                Log::error('Info Antrol pool error', [
                    'error' => $e->getMessage(),
                ]);

                foreach ($requests as $name => $url) {
                    $results[$name] = '❌ Gagal menghubungi API';
                }
            }
        }

        return "📋 INFO ANTROL\n\n"
            . "🏥 RSUD: " . ($results['RSUD'] ?? '❌ Tidak diproses') . "\n"
            . "🏥 RSIA: " . ($results['RSIA'] ?? '❌ Tidak diproses') . "\n\n"
            . "Trigger yang berhasil diterima akan diproses oleh masing-masing sistem Antrol.";
    }
}
<?php

namespace App\Services\WorkSession;

use App\Models\WorkSession;

class InfoWorkSessionService
{
    public function execute(): string
    {
        $sessions = WorkSession::query()
            ->with([
                'user',
                'workRequest',
            ])
            ->whereNull('ended_at')
            ->orderBy('started_at')
            ->get();

        if ($sessions->isEmpty()) {
            return implode("\n", [
                'ℹ️ Tidak ada Work Session aktif.',
            ]);
        }

        $lines = [
            '🟢 WORK SESSION AKTIF',
            '',
        ];

        foreach ($sessions as $index => $session) {
            $lines[] = ($index + 1) . '. ' . (
                $session->user?->name ?? '-'
            );

            $lines[] = '   Request : ' . (
                $session->workRequest?->judul ?? '-'
            );

            $lines[] = '   Mulai   : ' . (
                $session->started_at?->format('d M Y H:i') ?? '-'
            );

            $lines[] = '   Durasi  : ' . (
                $this->formatDuration($session->started_at)
            );

            $lines[] = '';
        }

        return implode("\n", $lines);
    }

    protected function formatDuration($startedAt): string
    {
        if (! $startedAt) {
            return '-';
        }

        $minutes = $startedAt->diffInMinutes(now());

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0) {
            return "{$hours}j {$remainingMinutes}m";
        }

        return "{$remainingMinutes} menit";
    }
}
<?php

namespace App\Services\WorkSession;

use App\Models\User;
use App\Models\WorkSession;

class InfoWorkSessionService
{
    public function execute(User $user): string
    {
        $session = WorkSession::query()
            ->where('user_id', $user->id)
            ->whereNull('ended_at')
            ->latest('started_at')
            ->first();

        if (! $session) {
            return implode("\n", [
                'ℹ️ Tidak ada Work Session aktif.',
                '',
                'Gunakan /start untuk memulai session.',
            ]);
        }

        return implode("\n", [
            '🟢 Work Session aktif',
            '',
            "Mulai    : {$session->started_at->format('d M Y H:i')}",
            "Durasi   : {$this->formatDuration($session->started_at)}",
            '',
            "Request  : " . (
                $session->workRequest?->judul ?? '-'
            ),
        ]);
    }

    protected function formatDuration($startedAt): string
    {
        $minutes = $startedAt->diffInMinutes(now());

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($hours > 0) {
            return "{$hours}j {$remainingMinutes}m";
        }

        return "{$remainingMinutes} menit";
    }
}
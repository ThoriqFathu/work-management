<?php

namespace App\Services\Telegram;

use App\Models\RequesterUnit;

class InfoRequesterService
{
    public function execute(): string
    {
        $requesters = RequesterUnit::query()
            ->where('aktif', true)
            ->orderBy('nama')
            ->get();

        if ($requesters->isEmpty()) {
            return "📋 MASTER REQUESTER\n\nBelum ada requester yang aktif.";
        }

        $lines = [
            '📋 MASTER REQUESTER',
            '',
        ];

        foreach ($requesters as $index => $requester) {
            $lines[] = sprintf(
                '%d. %s',
                $index + 1,
                $requester->nama
            );
        }

        $lines[] = '';
        $lines[] = 'Total: ' . $requesters->count() . ' requester';

        return implode("\n", $lines);
    }
}

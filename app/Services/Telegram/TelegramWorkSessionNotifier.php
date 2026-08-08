<?php

namespace App\Services\Telegram;

use App\Models\User;
use App\Models\WorkSession;

class TelegramWorkSessionNotifier
{
    public function __construct(
        protected TelegramBotService $telegram,
    ) {
    }

    public function started(
        WorkSession $session,
        User $user,
    ): void {
        $telegramUser = $user->telegramUser;

        if (! $telegramUser) {
            return;
        }

        $telegramChats = $telegramUser->chats()
            ->where('telegram_chats.is_active', true)
            ->get();

        if ($telegramChats->isEmpty()) {
            return;
        }

        $workRequest = $session->workRequest;

        $message = implode("\n", [
            '🔵 *Work Session Dimulai*',
            '',
            "📋 Request: {$workRequest->kode}",
            "📝 {$workRequest->judul}",
            "👤 Oleh: {$user->name}",
            '🕐 Mulai: ' . $session->started_at->format('d-m-Y H:i'),
        ]);

        foreach ($telegramChats as $chat) {
            $this->telegram->sendMessage(
                $chat->telegram_chat_id,
                $message,
            );
        }
    }
    
    public function stopped(
        WorkSession $session,
    ): void {
        $user = $session->user;

        if (! $user) {
            return;
        }

        $telegramUser = $user->telegramUser;

        if (! $telegramUser) {
            return;
        }

        $telegramChats = $telegramUser->chats()
            ->where('telegram_chats.is_active', true)
            ->get();

        if ($telegramChats->isEmpty()) {
            return;
        }

        $workRequest = $session->workRequest;

        $duration = $session->durasi_menit;

        $hours = intdiv($duration, 60);
        $minutes = $duration % 60;

        $durationText = $hours > 0
            ? "{$hours} jam {$minutes} menit"
            : "{$minutes} menit";

        $message = implode("\n", [
            '🟢 *Work Session Selesai*',
            '',
            "📋 Request: {$workRequest->kode}",
            "📝 {$workRequest->judul}",
            "👤 Oleh: {$user->name}",
            '🕐 Mulai: ' . $session->started_at->format('d-m-Y H:i'),
            '🕐 Selesai: ' . $session->ended_at->format('d-m-Y H:i'),
            "⏱️ Durasi: {$durationText}",
        ]);

        foreach ($telegramChats as $chat) {
            try {
                $this->telegram->sendMessage(
                    $chat->telegram_chat_id,
                    $message,
                );
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }
}
<?php

namespace App\Services\Telegram;

use App\Models\TelegramChat;
use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterTelegramMemberService
{
    public function execute(
        int $telegramChatId,
        array $chatData,
        int $telegramUserId,
        array $userData,
        User $user,
    ): TelegramUser {

        return DB::transaction(function () use (
            $telegramChatId,
            $chatData,
            $telegramUserId,
            $userData,
            $user,
        ) {

            $chat = TelegramChat::updateOrCreate(
                [
                    'telegram_chat_id' => $telegramChatId,
                ],
                [
                    'title' => $chatData['title'] ?? null,
                    'type' => $chatData['type'] ?? 'group',
                    'is_active' => true,
                ]
            );

            $telegramUser = TelegramUser::updateOrCreate(
                [
                    'telegram_user_id' => $telegramUserId,
                ],
                [
                    'user_id' => $user->id,
                    'username' => $userData['username'] ?? null,
                    'first_name' => $userData['first_name'] ?? null,
                    'last_name' => $userData['last_name'] ?? null,
                    'is_active' => true,
                ]
            );

            $chat->users()->syncWithoutDetaching([
                $telegramUser->id,
            ]);

            return $telegramUser;
        });
    }
}
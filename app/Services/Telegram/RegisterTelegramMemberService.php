<?php

namespace App\Services\Telegram;

use App\Models\TelegramChat;
use App\Models\TelegramUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class RegisterTelegramMemberService
{
    public function execute(
        int $telegramChatId,
        array $chatData,
        int $telegramUserId,
        array $userData,
    ): array {
        return DB::transaction(function () use (
            $telegramChatId,
            $chatData,
            $telegramUserId,
            $userData,
        ) {

            $username = trim($userData['username'] ?? '');

            if ($username === '') {
                throw new RuntimeException(
                    'Username Telegram wajib diisi.'
                );
            }

            $firstName = trim($userData['first_name'] ?? '');

            if ($firstName === '') {
                throw new RuntimeException(
                    'Nama depan Telegram wajib diisi.'
                );
            }

            $lastName = trim($userData['last_name'] ?? '');

            /*
            |--------------------------------------------------------------------------
            | Laravel User
            |--------------------------------------------------------------------------
            */

            $email = strtolower($username) . '@tes.com';

            $user = User::where('email', $email)->first();

            if (! $user) {

                $name = trim(
                    $firstName . ' ' . $lastName
                );

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password'),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Telegram Chat
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | Telegram User
            |--------------------------------------------------------------------------
            */

            $telegramUser = TelegramUser::updateOrCreate(
                [
                    'telegram_user_id' => $telegramUserId,
                ],
                [
                    'user_id' => $user->id,
                    'username' => $username,
                    'first_name' => $firstName,
                    'last_name' => $lastName ?: null,
                    'is_active' => true,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Chat Member
            |--------------------------------------------------------------------------
            */

            $chat->users()->syncWithoutDetaching([
                $telegramUser->id,
            ]);

            return [
                'user' => $user,
                'telegramUser' => $telegramUser,
                'telegramChat' => $chat,
            ];
        });
    }
}
<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Telegram\RegisterTelegramMemberService;
use Illuminate\Console\Command;

class RegisterTelegramMember extends Command
{
    protected $signature = 'telegram:register-member
        {laravel_user_id : ID user Laravel}
        {telegram_user_id : ID user Telegram}
        {--chat-id= : ID chat Telegram}
        {--title= : Nama group Telegram}
        {--type=supergroup : Tipe chat Telegram}
        {--username= : Username Telegram}
        {--first-name= : Nama depan Telegram}
        {--last-name= : Nama belakang Telegram}';

    protected $description = 'Register Telegram user ke chat Telegram';

    public function handle(
        RegisterTelegramMemberService $service
    ): int {

        $chatId = $this->option('chat-id');

        if (! $chatId) {
            $this->error('--chat-id wajib diisi.');

            return self::FAILURE;
        }

        $user = User::find(
            $this->argument('laravel_user_id')
        );

        if (! $user) {
            $this->error(
                'User Laravel tidak ditemukan.'
            );

            return self::FAILURE;
        }

        $telegramUser = $service->execute(

            telegramChatId: (int) $chatId,

            chatData: [
                'title' => $this->option('title'),
                'type' => $this->option('type'),
            ],

            telegramUserId: (int) $this->argument(
                'telegram_user_id'
            ),

            userData: [
                'username' => $this->option('username'),
                'first_name' => $this->option('first-name'),
                'last_name' => $this->option('last-name'),
            ],

            user: $user,
        );

        $this->info(
            "Telegram user berhasil didaftarkan: {$telegramUser->id}"
        );

        return self::SUCCESS;
    }
}
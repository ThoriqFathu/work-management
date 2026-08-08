<?php

namespace App\Console\Commands;

use App\Services\Telegram\RegisterTelegramMemberService;
use Illuminate\Console\Command;

class RegisterTelegramMember extends Command
{
    protected $signature = 'telegram:register-member
        {telegram_user_id : ID user Telegram}
        {--chat-id= : ID chat Telegram}
        {--title= : Nama group Telegram}
        {--type=supergroup : Tipe chat Telegram}
        {--username= : Username Telegram}
        {--first-name= : Nama depan Telegram}
        {--last-name= : Nama belakang Telegram}';

    protected $description = 'Register Telegram user dan otomatis membuat Laravel User';

    public function handle(
        RegisterTelegramMemberService $service
    ): int {
        $chatId = $this->option('chat-id');

        if (! $chatId) {
            $this->error('--chat-id wajib diisi.');

            return self::FAILURE;
        }

        $telegramUserId = (int) $this->argument('telegram_user_id');

        $username = $this->option('username');
        $firstName = $this->option('first-name');
        $lastName = $this->option('last-name');

        if (! $username) {
            $this->error('--username wajib diisi.');

            return self::FAILURE;
        }

        if (! $firstName) {
            $this->error('--first-name wajib diisi.');

            return self::FAILURE;
        }

        $result = $service->execute(
            telegramChatId: (int) $chatId,

            chatData: [
                'title' => $this->option('title'),
                'type' => $this->option('type'),
            ],

            telegramUserId: $telegramUserId,

            userData: [
                'username' => $username,
                'first_name' => $firstName,
                'last_name' => $lastName,
            ],
        );

        $this->newLine();

        $this->info('Telegram user berhasil didaftarkan.');

        $this->line("Laravel User ID : {$result['user']->id}");
        $this->line("Nama            : {$result['user']->name}");
        $this->line("Email           : {$result['user']->email}");
        $this->line("Password        : password");

        $this->newLine();

        $this->line("Telegram User ID: {$result['telegramUser']->telegram_user_id}");
        $this->line("Username        : @{$result['telegramUser']->username}");

        $this->newLine();

        $this->line("Chat ID         : {$result['telegramChat']->telegram_chat_id}");
        $this->line("Chat            : {$result['telegramChat']->title}");

        return self::SUCCESS;
    }
}
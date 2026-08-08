<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram_chat_user', function (Blueprint $table) {

            $table->id();

            $table->foreignId('telegram_chat_id')
                ->constrained('telegram_chats')
                ->cascadeOnDelete();

            $table->foreignId('telegram_user_id')
                ->constrained('telegram_users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'telegram_chat_id',
                'telegram_user_id',
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_chat_user');
    }
};
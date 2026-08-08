<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram_chats', function (Blueprint $table) {

            $table->id();

            // ID chat Telegram, bisa negatif untuk group/supergroup
            $table->bigInteger('telegram_chat_id')->unique();

            $table->string('title')->nullable();

            // private | group | supergroup
            $table->string('type', 20);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_chats');
    }
};
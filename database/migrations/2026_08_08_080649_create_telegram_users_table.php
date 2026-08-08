<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram_users', function (Blueprint $table) {

            $table->id();

            // User Laravel
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Telegram User ID
            $table->bigInteger('telegram_user_id')->unique();

            $table->string('username')->nullable();

            $table->string('first_name')->nullable();

            $table->string('last_name')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique([
                'user_id',
                'telegram_user_id',
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_users');
    }
};
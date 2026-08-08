<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('requester_unit_id')
                ->nullable()
                ->constrained('requester_units')
                ->nullOnDelete();

            $table->string('tipe', 50);

            $table->string('channel', 50)
                ->nullable();

            $table->unsignedInteger('durasi_menit');

            $table->text('ringkasan');

            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['requester_unit_id', 'created_at']);
            $table->index(['tipe', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_activities');
    }
};
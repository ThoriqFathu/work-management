<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_session_outputs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('work_session_id')
                ->constrained()
                ->cascadeOnDelete();

            // file | link | text
            $table->string('tipe', 20);

            // Judul output
            $table->string('nama');

            /*
            |--------------------------------------------------------------------------
            | Link
            |--------------------------------------------------------------------------
            */
            $table->text('url')->nullable();

            /*
            |--------------------------------------------------------------------------
            | File
            |--------------------------------------------------------------------------
            */
            $table->string('storage_path')->nullable();

            $table->string('original_filename')->nullable();

            $table->string('mime_type')->nullable();

            $table->unsignedBigInteger('size')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Text
            |--------------------------------------------------------------------------
            */
            $table->longText('content')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Catatan
            |--------------------------------------------------------------------------
            */
            $table->text('catatan')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Urutan
            |--------------------------------------------------------------------------
            */
            $table->unsignedSmallInteger('urutan')->default(1);

            $table->softDeletes();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_session_outputs');
    }
};
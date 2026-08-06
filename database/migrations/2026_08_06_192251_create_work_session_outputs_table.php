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

            // Nama output
            $table->string('nama');

            // Path file / URL / isi text
            $table->longText('value');

            // Keterangan tambahan
            $table->text('catatan')->nullable();

            // Urutan tampilan
            $table->unsignedSmallInteger('urutan')->default(1);

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
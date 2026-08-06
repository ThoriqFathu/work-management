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
        Schema::create('work_requests', function (Blueprint $table) {

            $table->id();

            $table->string('kode')->unique();

            $table->string('judul');

            $table->longText('deskripsi')->nullable();

            $table->foreignId('unit_kerja_id')->constrained('unit_kerja');

            $table->foreignId('requester_unit_id')->constrained();

            $table->enum('source', [
                'whatsapp',
                'telepon',
                'lisan',
                'email',
                'internal',
            ]);

            $table->foreignId('category_id')->constrained();

            $table->foreignId('priority_id')->constrained();

            $table->foreignId('status_id')->constrained();

            $table->foreignId('assigned_to')->nullable()->constrained('users');

            $table->foreignId('created_by')->constrained('users');

            $table->date('request_date');

            $table->unsignedInteger('estimasi_menit')->nullable();

            $table->unsignedInteger('aktual_menit')->default(0);

            $table->dateTime('deadline')->nullable();

            $table->timestamp('started_at')->nullable();

            $table->timestamp('finished_at')->nullable();

            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_requests');
    }
};

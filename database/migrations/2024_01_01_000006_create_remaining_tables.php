<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akreditasi', function (Blueprint $table) {
            $table->id();
            $table->string('program_studi');
            $table->enum('jenjang', ['D3', 'S1', 'S2', 'S3', 'Profesi']);
            $table->string('status_akreditasi', 50);
            $table->string('lembaga_akreditasi', 100)->default('BAN-PT');
            $table->string('nomor_sk', 100)->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->date('masa_berlaku')->nullable();
            $table->string('link_bukti', 500)->nullable();
            $table->string('file_sertifikat', 500)->nullable();
            $table->timestamps();
        });

        Schema::create('survei', function (Blueprint $table) {
            $table->id();
            $table->string('nama_survei');
            $table->year('tahun');
            $table->tinyInteger('triwulan')->nullable();
            $table->string('url_hasil', 500)->nullable();
            $table->integer('jumlah_responden')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('kepuasan_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('aspek', 100);
            $table->decimal('tidak_puas', 8, 2)->default(0);
            $table->decimal('kurang_puas', 8, 2)->default(0);
            $table->decimal('puas', 8, 2)->default(0);
            $table->decimal('sangat_puas', 8, 2)->default(0);
            $table->decimal('skor_rata', 5, 2)->default(0);
            $table->year('tahun');
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action', 50);
            $table->string('model_type', 100)->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('kepuasan_mahasiswa');
        Schema::dropIfExists('survei');
        Schema::dropIfExists('akreditasi');
    }
};

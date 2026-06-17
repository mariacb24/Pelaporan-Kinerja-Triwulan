<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realisasi_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indikator_id')->constrained('indikator_kinerja')->onDelete('restrict');
            $table->tinyInteger('triwulan')->comment('1=TW1, 2=TW2, 3=TW3, 4=TW4');
            $table->year('tahun');
            $table->decimal('target', 15, 2);
            $table->decimal('realisasi', 15, 2)->default(0);
            $table->decimal('persentase', 8, 2)->default(0);
            $table->decimal('nilai', 10, 4)->default(0);
            $table->decimal('bobot_snapshot', 5, 2)->default(1.00);
            $table->text('keterangan')->nullable();
            $table->enum('status_verifikasi', ['draft', 'menunggu', 'terverifikasi', 'ditolak'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->unique(['indikator_id', 'triwulan', 'tahun'], 'uk_realisasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realisasi_kinerja');
    }
};

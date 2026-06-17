<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_indikator', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('indikator_kinerja', function (Blueprint $table) {
            $table->id();
            $table->string('kode_indikator', 20)->unique();
            $table->string('nama_indikator');
            $table->foreignId('kategori_id')->constrained('kategori_indikator')->onDelete('restrict');
            $table->decimal('target', 15, 2);
            $table->string('satuan', 50);
            $table->decimal('bobot', 5, 2)->default(1.00);
            $table->text('formula_penilaian')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator_kinerja');
        Schema::dropIfExists('kategori_indikator');
    }
};

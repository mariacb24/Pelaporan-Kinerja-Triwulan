<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_website', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->string('kategori', 100);
            $table->string('url_dokumen', 500)->nullable();
            $table->year('tahun');
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tidak_tersedia');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('dokumen_spmi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->string('kategori', 100);
            $table->string('link_drive', 500)->nullable();
            $table->string('file_path', 500)->nullable();
            $table->enum('status', ['lengkap', 'tidak_lengkap', 'proses'])->default('proses');
            $table->year('tahun');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('pedoman_sop', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pedoman');
            $table->enum('jenis', ['pedoman', 'sop', 'panduan'])->default('sop');
            $table->string('url', 500)->nullable();
            $table->string('file_path', 500)->nullable();
            $table->year('tahun');
            $table->enum('status', ['aktif', 'revisi', 'tidak_aktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedoman_sop');
        Schema::dropIfExists('dokumen_spmi');
        Schema::dropIfExists('dokumen_website');
    }
};

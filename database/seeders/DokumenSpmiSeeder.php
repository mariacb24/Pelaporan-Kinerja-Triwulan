<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DokumenSpmi;

class DokumenSpmiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_dokumen' => 'Struktur Organisasi BPM',    'kategori' => 'Kelembagaan', 'tahun' => 2025, 'status' => 'lengkap'],
            ['nama_dokumen' => 'SK Auditor Internal',         'kategori' => 'Audit',       'tahun' => 2025, 'status' => 'lengkap'],
            ['nama_dokumen' => 'Hasil Audit Mutu Internal',   'kategori' => 'Audit',       'tahun' => 2025, 'status' => 'proses'],
            ['nama_dokumen' => 'Laporan AMI',                 'kategori' => 'Audit',       'tahun' => 2025, 'status' => 'tidak_lengkap'],
            ['nama_dokumen' => 'Notulen RTM',                 'kategori' => 'Manajemen',   'tahun' => 2025, 'status' => 'lengkap'],
            ['nama_dokumen' => 'Instrumen SPMI',              'kategori' => 'SPMI',        'tahun' => 2025, 'status' => 'lengkap'],
            ['nama_dokumen' => 'Laporan Evaluasi Diri (LED)', 'kategori' => 'Akreditasi',  'tahun' => 2025, 'status' => 'proses'],
        ];
        foreach ($data as $item) {
            DokumenSpmi::firstOrCreate(
                ['nama_dokumen' => $item['nama_dokumen'], 'tahun' => $item['tahun']],
                $item
            );
        }
    }
}

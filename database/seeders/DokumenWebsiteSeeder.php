<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DokumenWebsite;

class DokumenWebsiteSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_dokumen' => 'RIP (Rencana Induk Pengembangan)',  'kategori' => 'Dokumen Perencanaan', 'tahun' => 2025, 'status' => 'tersedia'],
            ['nama_dokumen' => 'Renstra (Rencana Strategis)',        'kategori' => 'Dokumen Perencanaan', 'tahun' => 2025, 'status' => 'tersedia'],
            ['nama_dokumen' => 'Kebijakan Mutu',                     'kategori' => 'Dokumen Mutu',        'tahun' => 2025, 'status' => 'tersedia'],
            ['nama_dokumen' => 'Sasaran Mutu',                       'kategori' => 'Dokumen Mutu',        'tahun' => 2025, 'status' => 'tidak_tersedia'],
            ['nama_dokumen' => 'Manual Mutu',                        'kategori' => 'Dokumen Mutu',        'tahun' => 2025, 'status' => 'tersedia'],
            ['nama_dokumen' => 'Statuta',                            'kategori' => 'Dokumen Kelembagaan', 'tahun' => 2025, 'status' => 'tersedia'],
            ['nama_dokumen' => 'Pedoman Akademik',                   'kategori' => 'Dokumen Akademik',    'tahun' => 2025, 'status' => 'tersedia'],
            ['nama_dokumen' => 'Kurikulum Program Studi',            'kategori' => 'Dokumen Akademik',    'tahun' => 2025, 'status' => 'tidak_tersedia'],
        ];
        foreach ($data as $item) {
            DokumenWebsite::firstOrCreate(
                ['nama_dokumen' => $item['nama_dokumen'], 'tahun' => $item['tahun']],
                $item
            );
        }
    }
}

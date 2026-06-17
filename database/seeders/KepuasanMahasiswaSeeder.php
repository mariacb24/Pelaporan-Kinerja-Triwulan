<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KepuasanMahasiswa;

class KepuasanMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['aspek' => 'Reliability (Keandalan)',      'tidak_puas' => 5,  'kurang_puas' => 15, 'puas' => 55, 'sangat_puas' => 25, 'skor_rata' => 3.00, 'tahun' => 2025],
            ['aspek' => 'Responsiveness (Ketanggapan)', 'tidak_puas' => 8,  'kurang_puas' => 20, 'puas' => 48, 'sangat_puas' => 24, 'skor_rata' => 2.88, 'tahun' => 2025],
            ['aspek' => 'Assurance (Jaminan)',          'tidak_puas' => 3,  'kurang_puas' => 12, 'puas' => 52, 'sangat_puas' => 33, 'skor_rata' => 3.15, 'tahun' => 2025],
            ['aspek' => 'Empathy (Empati)',             'tidak_puas' => 6,  'kurang_puas' => 18, 'puas' => 50, 'sangat_puas' => 26, 'skor_rata' => 2.96, 'tahun' => 2025],
            ['aspek' => 'Tangible (Bukti Fisik)',       'tidak_puas' => 4,  'kurang_puas' => 10, 'puas' => 58, 'sangat_puas' => 28, 'skor_rata' => 3.10, 'tahun' => 2025],
        ];
        foreach ($data as $item) {
            KepuasanMahasiswa::firstOrCreate(
                ['aspek' => $item['aspek'], 'tahun' => $item['tahun']],
                $item
            );
        }
    }
}

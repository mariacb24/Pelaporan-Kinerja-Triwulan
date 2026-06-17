<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akreditasi;

class AkreditasiSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama
        Akreditasi::truncate();

        $data = [
            [
                'program_studi'      => 'Manajemen',
                'jenjang'            => 'S1',
                'status_akreditasi'  => 'Baik Sekali',
                'lembaga_akreditasi' => 'BAN-PT',
                'nomor_sk'           => null,
                'tanggal_sk'         => null,
                'masa_berlaku'       => null,
                'link_bukti'         => null,
            ],
            [
                'program_studi'      => 'Akuntansi',
                'jenjang'            => 'S1',
                'status_akreditasi'  => 'Baik',
                'lembaga_akreditasi' => 'BAN-PT',
                'nomor_sk'           => null,
                'tanggal_sk'         => null,
                'masa_berlaku'       => null,
                'link_bukti'         => null,
            ],
            [
                'program_studi'      => 'Ilmu Hukum',
                'jenjang'            => 'S1',
                'status_akreditasi'  => 'Baik',
                'lembaga_akreditasi' => 'BAN-PT',
                'nomor_sk'           => null,
                'tanggal_sk'         => null,
                'masa_berlaku'       => null,
                'link_bukti'         => null,
            ],
            [
                'program_studi'      => 'Arsitektur',
                'jenjang'            => 'S1',
                'status_akreditasi'  => 'Baik',
                'lembaga_akreditasi' => 'BAN-PT',
                'nomor_sk'           => null,
                'tanggal_sk'         => null,
                'masa_berlaku'       => null,
                'link_bukti'         => null,
            ],
            [
                'program_studi'      => 'Teknik Industri',
                'jenjang'            => 'S1',
                'status_akreditasi'  => 'Baik',
                'lembaga_akreditasi' => 'BAN-PT',
                'nomor_sk'           => null,
                'tanggal_sk'         => null,
                'masa_berlaku'       => null,
                'link_bukti'         => null,
            ],
            [
                'program_studi'      => 'Ilmu Informatika',
                'jenjang'            => 'S1',
                'status_akreditasi'  => 'Baik Sekali',
                'lembaga_akreditasi' => 'BAN-PT',
                'nomor_sk'           => null,
                'tanggal_sk'         => null,
                'masa_berlaku'       => null,
                'link_bukti'         => null,
            ],
            [
                'program_studi'      => 'Akupuntur & Peng. Herbal',
                'jenjang'            => 'D3',
                'status_akreditasi'  => 'Baik',
                'lembaga_akreditasi' => 'LAM-PTKes',
                'nomor_sk'           => null,
                'tanggal_sk'         => null,
                'masa_berlaku'       => null,
                'link_bukti'         => null,
            ],
        ];

        foreach ($data as $item) {
            Akreditasi::create($item);
        }
    }
}

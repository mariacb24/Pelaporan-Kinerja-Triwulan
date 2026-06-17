<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriIndikator;

class KategoriIndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Akademik',              'deskripsi' => 'Indikator terkait proses akademik'],
            ['nama_kategori' => 'Kemahasiswaan',         'deskripsi' => 'Indikator terkait kemahasiswaan'],
            ['nama_kategori' => 'Penelitian',            'deskripsi' => 'Indikator terkait penelitian dan publikasi'],
            ['nama_kategori' => 'Pengabdian Masyarakat', 'deskripsi' => 'Indikator terkait pengabdian masyarakat'],
            ['nama_kategori' => 'Kerjasama',             'deskripsi' => 'Indikator terkait kerjasama institusi'],
            ['nama_kategori' => 'SDM',                   'deskripsi' => 'Indikator terkait sumber daya manusia'],
            ['nama_kategori' => 'Sarana Prasarana',      'deskripsi' => 'Indikator terkait sarana dan prasarana'],
            ['nama_kategori' => 'Keuangan',              'deskripsi' => 'Indikator terkait pengelolaan keuangan'],
        ];

        foreach ($data as $item) {
            KategoriIndikator::firstOrCreate(['nama_kategori' => $item['nama_kategori']], $item);
        }
    }
}

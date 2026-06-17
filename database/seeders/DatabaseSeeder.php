<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            KategoriIndikatorSeeder::class,
            IndikatorKinerjaSeeder::class,
            DokumenWebsiteSeeder::class,
            DokumenSpmiSeeder::class,
            AkreditasiSeeder::class,
            KepuasanMahasiswaSeeder::class,
        ]);
    }
}

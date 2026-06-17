<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin',        'display_name' => 'Administrator',  'description' => 'Akses penuh ke seluruh sistem'],
            ['name' => 'operator_bpm', 'display_name' => 'Operator BPM',   'description' => 'Input data, upload dokumen, generate laporan'],
            ['name' => 'pimpinan',     'display_name' => 'Pimpinan',        'description' => 'Melihat dashboard, laporan, dan download PDF'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}

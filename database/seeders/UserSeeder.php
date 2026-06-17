<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin    = Role::where('name', 'admin')->first();
        $operator = Role::where('name', 'operator_bpm')->first();
        $pimpinan = Role::where('name', 'pimpinan')->first();

        User::firstOrCreate(['email' => 'admin@bpm.ac.id'], [
            'name'      => 'Administrator BPM',
            'password'  => Hash::make('password'),
            'role_id'   => $admin->id,
            'is_active' => true,
        ]);

        User::firstOrCreate(['email' => 'operator@bpm.ac.id'], [
            'name'      => 'Operator BPM',
            'password'  => Hash::make('password'),
            'role_id'   => $operator->id,
            'is_active' => true,
        ]);

        User::firstOrCreate(['email' => 'rektor@universitas.ac.id'], [
            'name'      => 'Rektor',
            'password'  => Hash::make('password'),
            'role_id'   => $pimpinan->id,
            'is_active' => true,
        ]);

        User::firstOrCreate(['email' => 'warek1@universitas.ac.id'], [
            'name'      => 'Wakil Rektor I',
            'password'  => Hash::make('password'),
            'role_id'   => $pimpinan->id,
            'is_active' => true,
        ]);
    }
}

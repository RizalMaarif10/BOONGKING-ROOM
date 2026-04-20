<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
    {

        User::create([
            'name' => 'Admin Kampus',
            'email' => 'admin@kampus.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@kampus.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}

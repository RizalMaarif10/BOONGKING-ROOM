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
            'name' => 'ADMINISTRATOR',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@sekolah.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}

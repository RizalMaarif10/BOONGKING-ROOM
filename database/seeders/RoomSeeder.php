<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{

    public function run()
    {

        Room::create([
            'nama_ruangan' => 'A1',
            'jenis_ruangan' => 'Kelas',
            'kapasitas' => 30,
            'fasilitas' => 'PC, Proyektor, AC'
        ]);

        Room::create([
            'nama_ruangan' => 'A2',
            'jenis_ruangan' => 'Kelas',
            'kapasitas' => 30,
            'fasilitas' => 'PC, Proyektor, AC'
        ]);

        Room::create([
            'nama_ruangan' => 'A3',
            'jenis_ruangan' => 'Kelas',
            'kapasitas' => 15,
            'fasilitas' => 'Proyektor, Meja Sidang'
        ]);
    }
}

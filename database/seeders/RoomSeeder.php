<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{

    public function run()
    {

        Room::create([
            'nama_ruangan' => 'Laboratorium Komputer',
            'jenis_ruangan' => 'Laboratorium',
            'kapasitas' => 30,
            'fasilitas' => 'PC, Proyektor, AC'
        ]);

        Room::create([
            'nama_ruangan' => 'Laboratorium IoT',
            'jenis_ruangan' => 'Laboratorium',
            'kapasitas' => 20,
            'fasilitas' => 'Arduino Kit, Sensor, WiFi'
        ]);

        Room::create([
            'nama_ruangan' => 'Ruang Sidang Skripsi',
            'jenis_ruangan' => 'Ruang Sidang',
            'kapasitas' => 15,
            'fasilitas' => 'Proyektor, Meja Sidang'
        ]);
    }
}

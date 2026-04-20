<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{

    public function run()
    {

        Booking::create([
            'user_id' => 2,
            'room_id' => 1,
            'tanggal' => '2026-03-10',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'keperluan' => 'Praktikum Pemrograman',
            'status' => 'approved'
        ]);

        Booking::create([
            'user_id' => 2,
            'room_id' => 2,
            'tanggal' => '2026-03-11',
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:00',
            'keperluan' => 'Praktikum IoT',
            'status' => 'pending'
        ]);
    }
}

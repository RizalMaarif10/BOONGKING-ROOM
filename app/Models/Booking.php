<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $fillable = [

        'user_id',
        'room_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'keperluan',
        'status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

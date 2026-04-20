<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'nama_ruangan',
        'jenis_ruangan_id',
        'kapasitas',
        'fasilitas'
    ];

    public function jenisRuangan()
    {
        return $this->belongsTo(JenisRuangan::class, 'jenis_ruangan_id');
    }
}

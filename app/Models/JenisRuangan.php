<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisRuangan extends Model
{
    protected $fillable = ['nama'];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'jenis_ruangan_id');
    }
}

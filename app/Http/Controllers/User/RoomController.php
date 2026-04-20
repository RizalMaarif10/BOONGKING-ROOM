<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomController extends Controller
{

public function index()
{
    $rooms = Room::with('jenisRuangan')->get();

    return view('user.rooms.index', [
        'rooms' => $rooms
    ]);
}
}

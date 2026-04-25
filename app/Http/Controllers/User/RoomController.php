<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use App\Models\JenisRuangan;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{

  public function index()
    {
        $jenisFilter = request('jenis', 'all');

        $rooms = Room::with('jenisRuangan')
            ->when($jenisFilter !== 'all', fn($q) => $q->where('jenis_ruangan_id', $jenisFilter))
            ->get();

        $allRooms    = Room::count();
        $myBookings  = Booking::where('user_id', Auth::id())->count();
        $myPending   = Booking::where('user_id', Auth::id())->where('status', 'pending')->count();
        $jenisRuangan = JenisRuangan::withCount('rooms')->get();

        return view('user.rooms.index', compact('rooms', 'allRooms', 'myBookings', 'myPending', 'jenisRuangan'));
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;

class DashboardController extends Controller
{

    public function index()
    {

        $totalRooms = Room::count();

        $totalUsers = User::count();

        $totalBookings = Booking::count();

        $pending = Booking::where('status', 'pending')->count();

        $latestBookings = Booking::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'totalUsers',
            'totalBookings',
            'pending',
            'latestBookings'
        ));
    }
}

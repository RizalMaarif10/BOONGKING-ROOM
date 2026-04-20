<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{

    public function index()
    {
        $status = request('status', 'all');

        $bookings = Booking::with(['user', 'room'])
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }


    public function approve($id)
    {

        $booking = Booking::findOrFail($id);

        $booking->status = 'approved';

        $booking->save();

        return redirect()->back()->with('success', 'Booking disetujui');
    }


    public function reject($id)
    {

        $booking = Booking::findOrFail($id);

        $booking->status = 'rejected';

        $booking->save();

        return redirect()->back()->with('success', 'Booking ditolak');
    }
}

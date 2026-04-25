<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Room;

class BookingController extends Controller
{
    public function index()
    {
        $allBookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $status = request('status', 'all');
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->get();

        $jenisFilter = request('jenis', 'all');
        $roomsQuery  = Room::with('jenisRuangan');

        if ($jenisFilter !== 'all') {
            $roomsQuery->where('jenis_ruangan_id', $jenisFilter);
        }

        $rooms = $roomsQuery->get();

        return view('user.bookings.index', compact('bookings', 'allBookings', 'rooms'));
    }

    public function create()
    {
        $rooms = Room::with('jenisRuangan')->get();
        return view('user.bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'tanggal'    => 'required|date',
            'jam_mulai'  => 'required',
            'jam_selesai' => 'required',
            'keperluan'  => 'required|string|max:255'
        ]);

        if ($request->jam_mulai >= $request->jam_selesai) {
            return back()
                ->withInput()
                ->with('error', 'Jam selesai harus lebih besar dari jam mulai');
        }

        $conflict = Booking::where('room_id', $request->room_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<', $request->jam_selesai)
                            ->where('jam_selesai', '>', $request->jam_mulai);
                    });
            })
            ->whereIn('status', ['approved', 'pending'])
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal ruangan sudah dipakai pada waktu tersebut');
        }

        Booking::create([
            'user_id'    => Auth::id(),
            'room_id'    => $request->room_id,
            'tanggal'    => $request->tanggal,
            'jam_mulai'  => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keperluan'  => $request->keperluan,
            'status'     => 'pending'
        ]);

        // Redirect ke create agar toast muncul di halaman yang sama
        return redirect()->route('booking.create')
            ->with('success', 'Booking berhasil diajukan, menunggu persetujuan admin');
    }

    public function getSlots(Request $request)
    {
        $roomId  = $request->room_id;
        $tanggal = $request->tanggal;

        if (!$roomId || !$tanggal) {
            return response()->json([]);
        }

        $bookings = Booking::where('room_id', $roomId)
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['approved', 'pending'])
            ->get(['jam_mulai', 'jam_selesai']);

        $slots = [];
        foreach ($bookings as $b) {
            $slots[] = [
                'start' => $b->jam_mulai,
                'end'   => $b->jam_selesai
            ];
        }

        return response()->json($slots);
    }

    public function schedule()
    {
        return view('user.schedule.index');
    }

    public function scheduleData()
    {
        $bookings = Booking::with(['room', 'user'])
            ->where('status', 'approved')
            ->get();

        $events = [];
        foreach ($bookings as $booking) {
            $events[] = [
                'title' => $booking->room->nama_ruangan,
                'start' => $booking->tanggal . ' ' . $booking->jam_mulai,
                'end'   => $booking->tanggal . ' ' . $booking->jam_selesai,
                'color' => '#0d6efd',
                'extendedProps' => [
                    'ruangan'  => $booking->room->nama_ruangan,
                    'user'     => $booking->user->name,
                    'keperluan' => $booking->keperluan,
                    'jam'      => $booking->jam_mulai . ' - ' . $booking->jam_selesai
                ]
            ];
        }

        return response()->json($events);
    }
}

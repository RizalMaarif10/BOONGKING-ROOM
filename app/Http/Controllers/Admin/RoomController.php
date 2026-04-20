<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{

    public function index()
    {
        $rooms = Room::with('jenisRuangan')->get();
        return view('admin.rooms.index', compact('rooms'));
    }


    public function create()
    {
        $jenisRuangan = \App\Models\JenisRuangan::withCount('rooms')->get();
        return view('admin.rooms.create', compact('jenisRuangan'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan'     => 'required',
            'jenis_ruangan_id' => 'required|exists:jenis_ruangans,id',
            'kapasitas'        => 'required|integer|min:1',
            'fasilitas'        => 'nullable',
        ]);

        Room::create($request->only(['nama_ruangan', 'jenis_ruangan_id', 'kapasitas', 'fasilitas']));

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil ditambahkan');
    }


    public function show($id) {}


    public function edit($id)
    {
        $room         = Room::findOrFail($id);
        $jenisRuangan = \App\Models\JenisRuangan::withCount('rooms')->get();
        return view('admin.rooms.edit', compact('room', 'jenisRuangan'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruangan'     => 'required',
            'jenis_ruangan_id' => 'required|exists:jenis_ruangans,id',
            'kapasitas'        => 'required|integer|min:1',
            'fasilitas'        => 'nullable',
        ]);

        $room = Room::findOrFail($id);
        $room->update($request->only(['nama_ruangan', 'jenis_ruangan_id', 'kapasitas', 'fasilitas']));

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil diupdate');
    }


    public function destroy($id)
    {

        $room = Room::findOrFail($id);

        $room->delete();

        return redirect('/admin/rooms')->with('success', 'Ruangan berhasil dihapus');
    }
}

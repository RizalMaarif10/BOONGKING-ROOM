<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisRuangan;

class JenisRuanganController extends Controller
{
    public function index()
    {
        $jenis = JenisRuangan::withCount('rooms')->latest()->get();
        return view('admin.jenis-ruangan.index', compact('jenis'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|unique:jenis_ruangans,nama']);
        JenisRuangan::create($request->only('nama'));
        return redirect()->route('admin.jenis-ruangan.index')->with('success', 'Jenis ruangan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|unique:jenis_ruangans,nama,' . $id]);
        JenisRuangan::findOrFail($id)->update($request->only('nama'));
        return redirect()->route('admin.jenis-ruangan.index')->with('success', 'Jenis ruangan berhasil diupdate');
    }

    public function destroy($id)
    {
        JenisRuangan::findOrFail($id)->delete();
        return redirect()->route('admin.jenis-ruangan.index')->with('success', 'Jenis ruangan berhasil dihapus');
    }
}

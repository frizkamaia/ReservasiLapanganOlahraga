<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lapangan = Lapangan::all();
        return view('admin.lapangan.index', compact('lapangan'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_lapangan' => 'required',
        'jenis' => 'required',
        'harga_per_jam' => 'required|integer',
        'deskripsi' => 'nullable',
        'foto' => 'required|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    // Upload foto
    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('foto_lapangan', 'public');
    }

    // SIMPAN KE DATABASE
    Lapangan::create([
        'nama_lapangan' => $request->nama_lapangan,
        'jenis' => $request->jenis,
        'harga_per_jam' => $request->harga_per_jam,
        'deskripsi' => $request->deskripsi,
        'foto' => $fotoPath,
    ]);

    // REDIRECT
    return redirect()->route('admin.lapangan.index')->with('success', 'Data lapangan berhasil disimpan');
}

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function show(Lapangan $lapangan)
    {
        //
}

public function edit(Lapangan $lapangan)
{
    return view('admin.lapangan.edit', compact('lapangan'));
}

    public function update(Request $request, $id)
{
    $lapangan = Lapangan::findOrFail($id);

    $request->validate([
        'nama_lapangan' => 'required',
        'jenis' => 'required',
        'harga_per_jam' => 'required|integer',
        'deskripsi' => 'nullable',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $fotoPath = $lapangan->foto;

    if ($request->hasFile('foto')) {
        if ($lapangan->foto) {
            Storage::disk('public')->delete($lapangan->foto);
        }

        $fotoPath = $request->file('foto')->store('foto_lapangan', 'public');
    }

    $lapangan->update([
        'nama_lapangan' => $request->nama_lapangan,
        'jenis' => $request->jenis,
        'harga_per_jam' => $request->harga_per_jam,
        'deskripsi' => $request->deskripsi,
        'foto' => $fotoPath,
    ]);

    return redirect()->route('admin.lapangan.index')
        ->with('success', 'Data lapangan berhasil diperbarui!');
}

public function destroy($id)
{
    $lapangan = Lapangan::findOrFail($id);

    if ($lapangan->foto) {
        Storage::disk('public')->delete($lapangan->foto);
    }

    $lapangan->delete();

    return redirect()->route('admin.lapangan.index')
        ->with('success', 'Data lapangan berhasil dihapus!');
}

}

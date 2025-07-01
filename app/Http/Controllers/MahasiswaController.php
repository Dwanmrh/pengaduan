<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        $mahasiswas = Mahasiswa::all(); // admin bisa lihat semua
    } else {
        $mahasiswas = Mahasiswa::where('user_id', $user->id)->get(); // user lihat miliknya
    }

    return view('mahasiswa.index', compact('mahasiswas'));
}

public function create()
{
    return view('mahasiswa.create'); // semua boleh create
}

public function store(Request $request)
{
    $request->validate([
        'nim' => 'required|unique:mahasiswas',
        'nama' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'jurusan' => 'required|string|max:255',
    ]);

    Mahasiswa::create([
        'nim' => $request->nim,
        'nama' => $request->nama,
        'email' => $request->email,
        'jurusan' => $request->jurusan,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
}

public function edit(string $id)
{
    $mahasiswa = Mahasiswa::findOrFail($id);

    if (Auth::user()->role !== 'admin' && $mahasiswa->user_id !== Auth::id()) {
        abort(403);
    }

    return view('mahasiswa.edit', compact('mahasiswa'));
}

public function update(Request $request, string $id)
{
    $mahasiswa = Mahasiswa::findOrFail($id);

    if (Auth::user()->role !== 'admin' && $mahasiswa->user_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
        'nama' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'jurusan' => 'required|string|max:255',
    ]);

    $mahasiswa->update([
        'nim' => $request->nim,
        'nama' => $request->nama,
        'email' => $request->email,
        'jurusan' => $request->jurusan,
    ]);

    return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
}

public function destroy(string $id)
{
    $mahasiswa = Mahasiswa::findOrFail($id);

    if (Auth::user()->role !== 'admin' && $mahasiswa->user_id !== Auth::id()) {
        abort(403);
    }

    $mahasiswa->delete();

    return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
}
}

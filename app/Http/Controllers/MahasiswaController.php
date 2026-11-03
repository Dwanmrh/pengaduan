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
    $user = Auth::user();

    // Admin bebas menambah data. Mahasiswa hanya untuk dirinya sendiri, satu kali.
    if ($user->role === 'mahasiswa') {
        $milikSendiri = Mahasiswa::where('user_id', $user->id)->first();
        if ($milikSendiri) {
            return redirect()->route('mahasiswa.edit', $milikSendiri->id)
                ->with('success', 'Data Anda sudah ada. Silakan perbarui di sini.');
        }

        $akun = ['nama' => $user->name, 'email' => $user->email, 'nim' => $user->nim];
        return view('mahasiswa.create', compact('akun'));
    }

    if ($user->role !== 'admin') {
        abort(403, 'Anda tidak memiliki akses untuk menambah data mahasiswa.');
    }

    return view('mahasiswa.create');
}

public function store(Request $request)
{
    $user = Auth::user();

    if (!in_array($user->role, ['admin', 'mahasiswa'])) {
        abort(403, 'Anda tidak memiliki akses untuk menambah data mahasiswa.');
    }

    if ($user->role === 'mahasiswa') {
        if (Mahasiswa::where('user_id', $user->id)->exists()) {
            abort(403, 'Data mahasiswa Anda sudah ada.');
        }

        // NIM dan email diambil dari akun yang login, bukan dari input form
        $request->merge([
            'nim' => $user->nim ?: $request->nim,
            'email' => $user->email,
        ]);
    }

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

    // Mahasiswa tidak boleh mengganti NIM/email menjadi milik orang lain
    if (Auth::user()->role !== 'admin') {
        $request->merge([
            'nim' => Auth::user()->nim ?: $request->nim,
            'email' => Auth::user()->email,
        ]);
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

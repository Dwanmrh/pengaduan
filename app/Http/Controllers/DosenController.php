<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function index()
    {
        // Semua user bisa lihat semua dosen
        $dosens = Dosen::all();
        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        $user = Auth::user();

        // Admin bebas menambah data. Dosen hanya untuk dirinya sendiri, satu kali.
        if ($user->role === 'dosen') {
            $milikSendiri = Dosen::where('user_id', $user->id)->first();
            if ($milikSendiri) {
                return redirect()->route('dosen.edit', $milikSendiri->id)
                    ->with('success', 'Data Anda sudah ada. Silakan perbarui di sini.');
            }

            $akun = ['nama' => $user->name, 'email' => $user->email, 'nidn' => $user->nidn];
            return view('dosen.create', compact('akun'));
        }

        if ($user->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk menambah data dosen.');
        }

        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'dosen'])) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data dosen.');
        }

        if ($user->role === 'dosen') {
            if (Dosen::where('user_id', $user->id)->exists()) {
                abort(403, 'Data dosen Anda sudah ada.');
            }

            // NIDN dan email diambil dari akun yang login, bukan dari input form
            $request->merge([
                'nidn' => $user->nidn ?: $request->nidn,
                'email' => $user->email,
            ]);
        }

        $request->validate([
            'nidn' => 'required|unique:dosens,nidn',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        Dosen::create([
            'nidn' => $request->nidn,
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $dosen = Dosen::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $dosen->user_id !== Auth::id()) {
            abort(403);
        }

        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, string $id)
    {
        $dosen = Dosen::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $dosen->user_id !== Auth::id()) {
            abort(403);
        }

        // Dosen tidak boleh mengganti NIDN/email menjadi milik orang lain
        if (Auth::user()->role !== 'admin') {
            $request->merge([
                'nidn' => Auth::user()->nidn ?: $request->nidn,
                'email' => Auth::user()->email,
            ]);
        }

        $request->validate([
            'nidn' => 'required|unique:dosens,nidn,' . $dosen->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        $dosen->update([
            'nidn' => $request->nidn,
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $dosen = Dosen::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $dosen->user_id !== Auth::id()) {
            abort(403);
        }

        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}

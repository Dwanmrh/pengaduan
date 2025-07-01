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
        return view('dosen.create');
    }

    public function store(Request $request)
    {
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

<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{

    public function index()
    {
        if (Auth::user()->role === 'mahasiswa') {
            $pengaduans = Pengaduan::withCount('tanggapan') /// hitung jumlah tanggapan
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $pengaduans = Pengaduan::withCount('tanggapan')->get(); // untuk dosen & admin (withCount agar badge jumlah tanggapan tampil)
        }

        return view('pengaduan.index', compact('pengaduans'));
    }


    public function create()
    {
        if (!in_array(Auth::user()->role, ['mahasiswa', 'admin'])) {
            abort(403, 'Hanya mahasiswa dan admin yang dapat membuat pengaduan.');
        }
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['mahasiswa', 'admin'])) {
            abort(403, 'Hanya mahasiswa dan admin yang dapat membuat pengaduan.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengaduan' => 'required',
            'bagian' => 'required',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        $path = $request->file('lampiran')?->store('lampiran', 'public');

        Pengaduan::create([
            'judul' => $request->judul,
            'isi_pengaduan' => $request->isi_pengaduan,
            'bagian' => $request->bagian,
            'lampiran' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dibuat.');
    }

    public function show(string $id)
    {
        $pengaduan = Pengaduan::with('tanggapan')->findOrFail($id);

        // Mahasiswa hanya boleh melihat pengaduan miliknya sendiri
        if (Auth::user()->role === 'mahasiswa' && Auth::id() !== $pengaduan->user_id) {
            abort(403);
        }

        return view('pengaduan.show', compact('pengaduan'));
    }

    public function edit(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hanya admin atau mahasiswa yang punya pengaduan yang bisa edit
        if (
            !(Auth::user()->role === 'admin' ||
            (Auth::user()->role === 'mahasiswa' && Auth::id() === $pengaduan->user_id))
        ) {
            abort(403);
        }

        return view('pengaduan.edit', compact('pengaduan'));
    }


    public function update(Request $request, string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hanya admin atau mahasiswa pemilik pengaduan yang bisa memperbarui
        if (
            !(Auth::user()->role === 'admin' ||
            (Auth::user()->role === 'mahasiswa' && Auth::id() === $pengaduan->user_id))
        ) {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_pengaduan' => 'required',
            'bagian' => 'required',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        // Hapus lampiran lama jika ada lampiran baru
        if ($request->hasFile('lampiran')) {
            if ($pengaduan->lampiran) {
                Storage::disk('public')->delete($pengaduan->lampiran);
            }
            $path = $request->file('lampiran')->store('lampiran', 'public');
        } else {
            $path = $pengaduan->lampiran;
        }

        $pengaduan->update([
            'judul' => $request->judul,
            'isi_pengaduan' => $request->isi_pengaduan,
            'bagian' => $request->bagian,
            'lampiran' => $path,
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function like($id)
    {
        $pengaduan = Pengaduan::withCount('tanggapan')->findOrFail($id);
        if (Auth::id() !== $pengaduan->user_id) {
            abort(403);
        }

        // Pengaduan baru bisa ditandai selesai setelah ada tanggapan
        if ($pengaduan->tanggapan_count === 0) {
            return redirect()->route('pengaduan.index')->with('error', 'Pengaduan belum ditanggapi, sehingga belum bisa ditandai selesai.');
        }

        $pengaduan->status = 'selesai';
        $pengaduan->save();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan ditandai sebagai selesai.');
    }

    public function dislike($id)
    {
        $pengaduan = Pengaduan::with('tanggapan')->findOrFail($id);

        if (Auth::id() !== $pengaduan->user_id) {
            abort(403);
        }

        $pengaduan->status = 'diproses';
        $pengaduan->save();

        // Tambahkan notifikasi agar dosen bisa menanggapi ulang
        session()->flash("dislike_pengaduan_{$id}", true);
        return redirect()->route('pengaduan.index')->with('success', 'Status selesai dibatalkan dan pengaduan dapat ditanggapi ulang.');
    }

    public function destroy(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hanya admin atau mahasiswa yang punya pengaduan yang bisa hapus
        if (
            !(Auth::user()->role === 'admin' ||
            (Auth::user()->role === 'mahasiswa' && Auth::id() === $pengaduan->user_id))
        ) {
            abort(403);
        }

        if ($pengaduan->lampiran) {
            Storage::disk('public')->delete($pengaduan->lampiran);
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}

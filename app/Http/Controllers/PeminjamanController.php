<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->paginate(15);
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::orderBy('nama_lengkap')->get();
        $bukus = Buku::orderBy('judul')->get();
        return view('peminjaman.create', compact('users', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'UserID' => 'required|exists:users,id',
            'BukuID' => 'required|exists:bukus,id',
            'TanggalPeminjaman' => 'required|date',
            'TanggalPengembalian' => 'required|date|after_or_equal:TanggalPeminjaman',
        ]);

        Peminjaman::create([
            'UserID' => $request->UserID,
            'BukuID' => $request->BukuID,
            'TanggalPeminjaman' => $request->TanggalPeminjaman,
            'TanggalPengembalian' => $request->TanggalPengembalian,
            'StatusPeminjaman' => 'dipinjam',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'StatusPeminjaman' => 'dikembalikan',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    // === Peminjam-specific methods ===

    public function riwayat()
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('UserID', Auth::id())
            ->latest()
            ->paginate(15);

        return view('peminjaman.riwayat', compact('peminjamans'));
    }

    public function pinjam()
    {
        $bukus = Buku::orderBy('judul')->get();
        return view('peminjaman.pinjam', compact('bukus'));
    }

    public function storePinjam(Request $request)
    {
        $request->validate([
            'BukuID' => 'required|exists:bukus,id',
            'TanggalPengembalian' => 'required|date|after:today',
        ]);

        Peminjaman::create([
            'UserID' => Auth::id(),
            'BukuID' => $request->BukuID,
            'TanggalPeminjaman' => now()->toDateString(),
            'TanggalPengembalian' => $request->TanggalPengembalian,
            'StatusPeminjaman' => 'dipinjam',
        ]);

        return redirect()->route('peminjaman.riwayat')->with('success', 'Buku berhasil dipinjam.');
    }
}

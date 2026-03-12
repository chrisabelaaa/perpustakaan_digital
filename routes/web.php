<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $data = [];

    if (in_array($user->role, ['admin', 'petugas'])) {
        $data['totalBuku'] = Buku::count();
        $data['totalKategori'] = KategoriBuku::count();
        $data['totalDipinjam'] = Peminjaman::where('StatusPeminjaman', 'dipinjam')->count();
        $data['totalAnggota'] = User::where('role', 'peminjam')->count();
        $data['peminjamanTerbaru'] = Peminjaman::with(['user', 'buku'])->latest()->take(5)->get();
    } else {
        $data['totalDipinjam'] = Peminjaman::where('UserID', $user->id)->where('StatusPeminjaman', 'dipinjam')->count();
        $data['totalSelesai'] = Peminjaman::where('UserID', $user->id)->where('StatusPeminjaman', 'dikembalikan')->count();
        $data['riwayatTerbaru'] = Peminjaman::with('buku')->where('UserID', $user->id)->latest()->take(5)->get();
    }

    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Semua role: lihat buku (read-only)
    Route::get('buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

    // Peminjam: buat peminjaman + lihat peminjaman sendiri
    Route::get('peminjaman/saya', [PeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');
    Route::get('peminjaman/pinjam', [PeminjamanController::class, 'pinjam'])->name('peminjaman.pinjam');
    Route::post('peminjaman/pinjam', [PeminjamanController::class, 'storePinjam'])->name('peminjaman.storePinjam');

    // Admin & Petugas: CRUD buku, kategori, kelola peminjaman
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('buku', BukuController::class)->except(['index', 'show']);
        Route::resource('kategori', KategoriBukuController::class)->except(['create', 'show', 'edit']);
        Route::resource('peminjaman', PeminjamanController::class)->except(['show', 'edit']);
    });

    // Admin only: kelola petugas
    Route::middleware('admin')->group(function () {
        Route::resource('petugas', PetugasController::class)->only(['index', 'create', 'store', 'destroy']);
    });
});

require __DIR__ . '/auth.php';
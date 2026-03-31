<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    // Menampilkan daftar kategori buku dan data kategori yang sedang dipilih untuk diedit.
    public function index(Request $request)
    {
        $kategoris = KategoriBuku::withCount('bukus')->latest()->paginate(15);

        $edit = null;
        if ($request->has('edit')) {
            $edit = KategoriBuku::find($request->edit);
        }

        return view('kategori.index', compact('kategoris', 'edit'));
    }

    // Memvalidasi lalu menyimpan kategori buku baru.
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoribukus,nama',
        ]);

        KategoriBuku::create($request->only('nama'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Memvalidasi lalu memperbarui nama kategori yang dipilih.
    public function update(Request $request, KategoriBuku $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoribukus,nama,' . $kategori->id,
        ]);

        $kategori->update($request->only('nama'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Menghapus data kategori buku dari database.
    public function destroy(KategoriBuku $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}

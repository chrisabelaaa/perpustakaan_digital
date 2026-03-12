<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::latest()->paginate(15);
        return view('buku.index', compact('bukus'));
    }

    public function create()
    {
        $kategoris = KategoriBuku::orderBy('nama')->get();
        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategoribukus,id',
        ]);

        $data = $request->only(['judul', 'penulis', 'penerbit', 'tahun_terbit']);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku = Buku::create($data);
        $buku->kategoris()->sync($request->input('kategori_ids', []));

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        return redirect()->route('buku.index');
    }

    public function edit(Buku $buku)
    {
        $kategoris = KategoriBuku::orderBy('nama')->get();
        $buku->load('kategoris');
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'kategori_ids' => 'nullable|array',
            'kategori_ids.*' => 'exists:kategoribukus,id',
        ]);

        $data = $request->only(['judul', 'penulis', 'penerbit', 'tahun_terbit']);

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);
        $buku->kategoris()->sync($request->input('kategori_ids', []));

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}

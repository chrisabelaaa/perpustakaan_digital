<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = User::where('role', 'petugas')->latest()->paginate(15);
        return view('petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'alamat' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function destroy(User $petuga)
    {
        if ($petuga->role !== 'petugas') {
            return redirect()->route('petugas.index')->with('error', 'User ini bukan petugas.');
        }

        $petuga->delete();
        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }
}

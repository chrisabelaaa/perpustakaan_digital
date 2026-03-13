<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model untuk tabel buku.
 */
class Buku extends Model
{
    /**
     * Daftar atribut yang boleh diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'cover',
    ];

    /**
     * Relasi many-to-many antara buku dan kategori.
     */
    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategoribuku_relasis', 'BukuID', 'KategoriID');
    }

    /**
     * Relasi one-to-many ke data peminjaman.
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'BukuID');
    }
}

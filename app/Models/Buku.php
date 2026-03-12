<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'cover',
    ];

    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategoribuku_relasis', 'BukuID', 'KategoriID');
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'BukuID');
    }
}

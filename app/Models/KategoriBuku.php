<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model untuk tabel kategori buku.
 */
class KategoriBuku extends Model
{
    /**
     * Nama tabel karena tidak mengikuti plural default Laravel.
     *
     * @var string
     */
    protected $table = 'kategoribukus';

    /**
     * Daftar atribut yang boleh diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nama'];

    /**
     * Relasi many-to-many antara kategori dan buku.
     */
    public function bukus(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'kategoribuku_relasis', 'KategoriID', 'BukuID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model untuk transaksi peminjaman buku.
 */
class Peminjaman extends Model
{
    /**
     * Nama tabel karena tidak mengikuti plural default Laravel.
     *
     * @var string
     */
    protected $table = 'peminjamans';

    /**
     * Daftar atribut yang boleh diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'UserID',
        'BukuID',
        'TanggalPeminjaman',
        'TanggalPengembalian',
        'StatusPeminjaman',
    ];

    /**
     * Konversi otomatis atribut tanggal ke instance Carbon.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'TanggalPeminjaman' => 'date',
        'TanggalPengembalian' => 'date',
    ];

    /**
     * Relasi ke user yang melakukan peminjaman.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    /**
     * Relasi ke buku yang dipinjam.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }
}

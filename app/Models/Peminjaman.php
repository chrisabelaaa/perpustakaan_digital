<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'UserID',
        'BukuID',
        'TanggalPeminjaman',
        'TanggalPengembalian',
        'StatusPeminjaman',
    ];

    protected $casts = [
        'TanggalPeminjaman' => 'date',
        'TanggalPengembalian' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KategoriBuku extends Model
{
    protected $table = 'kategoribukus';

    protected $fillable = ['nama'];

    public function bukus(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'kategoribuku_relasis', 'KategoriID', 'BukuID');
    }
}

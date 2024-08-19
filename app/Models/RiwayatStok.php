<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RiwayatStok extends Model
{
    use HasFactory;

    protected $table = 'riwayat_stok';

    protected $fillable = [
        'riwayatable_id',
        'riwayatable_type',
        'stokable_id',
        'stokable_type',
        'barang_id',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function stokable(): MorphTo
    {
        return $this->morphTo();
    }

    public function riwayatable(): MorphTo
    {
        return $this->morphTo();
    }
}

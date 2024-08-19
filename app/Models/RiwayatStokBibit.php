<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class RiwayatStokBibit extends Model
{
    use HasFactory;

    protected $table = 'riwayat_stok_bibit';

    protected $fillable = [
        'dus',
        'kotak',
        'satuan'
    ];

    public function riwayatStok(): MorphOne
    {
        return $this->morphOne(RiwayatStok::class, 'riwayatable');
    }
}

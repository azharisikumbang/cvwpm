<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    use HasFactory;

    protected $table = 'riwayat_stok';

    protected $fillable = [
        'barang_id',
        'jumlah_dus',
        'jumlah_kotak',
        'jumlah_satuan',
        'keterangan',
        'stokable_id',
        'stokable_type',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }


}

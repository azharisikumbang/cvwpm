<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPembelianDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_pembelian_id',
        'barang_id',
        'jumlah_dus',
        'jumlah_kotak',
    ];

    public function pengejuanPembelian()
    {
        return $this->belongsTo(PengajuanPembelian::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}

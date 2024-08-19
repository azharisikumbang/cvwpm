<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPembelian extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pembelian';

    protected $fillable = [
        'nomor_pengajuan',
        'tanggal_pengajuan',
        'staf_pengaju_id',
        'gudang_pengaju_id',
        'status_pengajuan'
    ];
}

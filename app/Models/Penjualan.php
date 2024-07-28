<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'nomor',
        'nama_toko',
        'alamat_toko',
        'kontak_toko',
        'tanggal_transaksi',
        'sales_canvas_id',
    ];

    public function canvas()
    {
        return $this->belongsTo(SalesCanvas::class, 'sales_canvas_id');
    }

    public function riwayatStok(): MorphMany
    {
        return $this->morphMany(RiwayatStok::class, 'stokable');
    }

    public function salesCanvas(): BelongsTo
    {
        return $this->belongsTo(SalesCanvas::class, 'sales_canvas_id');
    }
}

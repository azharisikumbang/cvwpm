<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Penjualan extends Model
{
    use HasFactory;

    const FILE_FAKTUR_PENJUALAN_PATH = 'app/private/faktur-penjualan';

    protected $table = 'penjualan';

    protected $fillable = [
        'nomor',
        'nama_toko',
        'alamat_toko',
        'kontak_toko',
        'tanggal_transaksi',
        'sales_canvas_id',
        'file_faktur_penjualan'
        // TODO: harga setiap item penjualan harus tercatat agar dapat tetap valid saat dibutuhkan pembuatan laporan penjualan
    ];

    protected $appends = [
        'total'
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

    public function getTerjualDus()
    {
        return $this->riwayatStok->sum('jumlah_dus');
    }

    public function getTerjualKotak()
    {
        return $this->riwayatStok->sum('jumlah_kotak');
    }

    public function getTerjualSatuan()
    {
        return $this->riwayatStok->sum('jumlah_satuan');
    }

    public function getTotalAttribute()
    {
        return 0;
    }

    public function getFileFakturPenjualanWithFullPath()
    {
        return storage_path(self::FILE_FAKTUR_PENJUALAN_PATH . '/' . $this->file_faktur_penjualan);
    }
}

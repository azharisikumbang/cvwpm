<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    use HasFactory;

    const BARANG_MASUK = 'MASUK';
    const BARANG_KELUAR = 'KELUAR';

    const BARANG_MASUK_KELUAR = 'MASUK_KELUAR';

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

    protected $appends = [
        'total_pcs',
        'jumlah_text',
        'tipe_riwayat',
        'is_kartu_stok'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function getTotalPcsAttribute()
    {
        $barang = $this->barang;

        return $this->jumlah_satuan + ($this->jumlah_kotak * $barang->satuan_per_kotak) + ($this->jumlah_dus * $barang->satuan_per_dus);
    }

    public function getJumlahTextAttribute()
    {
        $barang = $this->barang;

        return "{$this->jumlah_dus} Dus, {$this->jumlah_kotak} Kotak, {$this->jumlah_satuan} {$barang->satuan}";
    }

    public function stokable()
    {
        return $this->morphTo();
    }

    public function getKeteranganAttribute($value)
    {
        return $value ?? $this->getDefaulKeterangan();
    }

    private function getDefaulKeterangan()
    {
        if ($this->stokable_type == PindahGudang::class)
        {
            return $this->stokable->jenis_pindah_gudang == PindahGudang::PINDAH_MASUK
                ? 'Pindah dari ' . $this->stokable->gudangAsal()->first()->nama
                : 'Pindah ke ' . $this->stokable->gudangTujuan()->first()->nama
            ;
        } else
        {
            return match ($this->stokable_type)
            {
                PurchaseOrder::class => 'Pembelian',
                DeliveryOrder::class => 'Barang Masuk PO',
                Penjualan::class => 'Sales ' . $this->stokable->nama_toko,
                SalesCanvas::class => 'Barang Keluar Canvas',
                default => '-'
            };
        }
    }

    public function getTipeRiwayatAttribute()
    {
        if ($this->stokable_type == PindahGudang::class)
        {
            return $this->stokable->jenis_pindah_gudang == PindahGudang::PINDAH_MASUK ? self::BARANG_MASUK : self::BARANG_KELUAR;
        } else
        {
            return match ($this->stokable_type)
            {
                DeliveryOrder::class => self::BARANG_MASUK,
                Penjualan::class => self::BARANG_KELUAR,
                SalesCanvas::class => self::BARANG_KELUAR,
                default => false
            };
        }

    }

    public function getIsKartuStokAttribute()
    {
        return true;
    }
}

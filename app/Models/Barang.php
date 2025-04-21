<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama',
        'gudang_id',
        'kemasan',
        'harga',
        'satuan',
        'jumlah_dus',
        'jumlah_satuan',
        'jumlah_kotak',
        'satuan_per_dus',
        'satuan_per_kotak',
        'kode_barang'
    ];

    protected $appends = [
        'harga_rupiah',
        'nama_kemasan',
        'jumlah_text',
        'jumlah_satuan_bukan_dus_kotak'
    ];

    public function getHargaRupiahAttribute()
    {
        return 'Rp. ' . number_format($this->harga, 0, ',', '.');
    }

    public function getHargaAttribute($value)
    {
        return (int) $value;
    }

    public function getNamaKemasanAttribute()
    {
        return $this->nama . ' ' . $this->kemasan;
    }

    public function getJumlahTextAttribute()
    {
        return $this->jumlah_dus . ' dus, ' . $this->jumlah_kotak . ' kotak, ' . $this->jumlah_satuan_bukan_dus_kotak . ' ' . $this->satuan;
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function validateGudang()
    {
        return $this->gudang_id === auth()->user()->staf->gudangKerja->id;
    }

    public function getBarangGudang()
    {
        return $this
            ->where('gudang_id', auth()->user()->staf->gudangKerja->id)
            ->orderBy('nama')
            ->latest()
            ->get();
    }

    public function riwayatStok()
    {
        return $this->hasMany(RiwayatStok::class);
    }

    public function getJumlahSatuanBukanDusKotakAttribute()
    {
        $pcs = $this->jumlah_satuan;

        return $pcs - ($this->jumlah_dus * $this->satuan_per_dus + $this->jumlah_kotak * $this->satuan_per_kotak);
    }
}

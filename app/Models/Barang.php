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
    ];

    protected $appends = [
        'harga_rupiah',
        'nama_kemasan',
        'jumlah_text',
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
        return $this->jumlah_dus . ' dus, ' . $this->jumlah_kotak . ' kotak, ' . $this->jumlah_satuan . ' ' . $this->satuan;
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
        return $this->where('gudang_id', auth()->user()->staf->gudangKerja->id)->get();
    }
}

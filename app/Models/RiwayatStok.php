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

    protected $appends = [
        'total_pcs',
        'jumlah_text'
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
}

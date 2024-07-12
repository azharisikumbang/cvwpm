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
        'harga',
        'satuan',
    ];

    protected $appends = [
        'harga_rupiah',
    ];

    public function getHargaRupiahAttribute()
    {
        return 'Rp. ' . number_format($this->harga, 0, ',', '.');
    }

    public function getHargaAttribute($value)
    {
        return (int) $value;
    }
}

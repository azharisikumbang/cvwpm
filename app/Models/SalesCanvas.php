<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SalesCanvas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat_jalan',
        'sales_id',
        'wilayah',
        'tanggal_mulai',
        'tanggal_selesai',
        'surat_jalan_file'
    ];

    public function sales()
    {
        return $this->belongsTo(Staf::class, 'sales_id');
    }

    public function riwayatStok(): MorphMany
    {
        return $this->morphMany(RiwayatStok::class, 'stokable');
    }
}

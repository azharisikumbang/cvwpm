<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PindahGudang extends Model
{
    use HasFactory;

    const PINDAH_KELUAR = 'KELUAR';

    const PINDAH_MASUK = 'MASUK';

    protected $table = 'pindah_gudang';

    protected $fillable = [
        'nomor_surat_jalan',
        'gudang_asal_id',
        'gudang_tujuan_id',
        'tanggal_pemindahan',
        'tanggal_penyelesaian',
        'jenis_pindah_gudang',
        'surat_jalan_file',
    ];

    public function gudangAsal()
    {
        return $this->belongsTo(Gudang::class, 'gudang_asal');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(Gudang::class, 'gudang_tujuan');
    }

    public function riwayatStok(): MorphMany
    {
        return $this->morphMany(RiwayatStok::class, 'stokable');
    }


}

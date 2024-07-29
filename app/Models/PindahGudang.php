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

    protected $appends = [
        'is_done',
        'kode_nama',
        'rute'
    ];

    public function gudangAsal()
    {
        return $this->belongsTo(Gudang::class, 'gudang_asal_id');
    }

    public function gudangTujuan()
    {
        return $this->belongsTo(Gudang::class, 'gudang_tujuan_id');
    }

    public function riwayatStok(): MorphMany
    {
        return $this->morphMany(RiwayatStok::class, 'stokable');
    }

    public function getIsDoneAttribute()
    {
        return !is_null($this->tanggal_penyelesaian);
    }

    public function getKodeNamaAttribute()
    {
        $gudang = $this->gudangAsal;

        return sprintf('%s (%s)', $gudang->nama, $gudang->kode_gudang);
    }

    public function getRuteAttribute()
    {
        return sprintf('%s -> %s', $this->gudangAsal->nama, $this->gudangTujuan->nama);
    }
}

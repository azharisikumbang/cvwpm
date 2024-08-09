<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SalesCanvas extends Model
{
    use HasFactory;

    const SURAT_JALAN_FILE_PATH = 'app/private/surat-jalan-canvas';

    protected $fillable = [
        'nomor_surat_jalan',
        'sales_id',
        'wilayah',
        'tanggal_mulai',
        'tanggal_selesai',
        'surat_jalan_file'
    ];

    protected $appends = [
        'is_done',
    ];

    public function sales()
    {
        return $this->belongsTo(Staf::class, 'sales_id');
    }

    public function riwayatStok(): MorphMany
    {
        return $this->morphMany(RiwayatStok::class, 'stokable');
    }

    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'sales_canvas_id');
    }

    public function getIsDoneAttribute()
    {
        return !is_null($this->tanggal_selesai);
    }

    public function markAsDone()
    {
        $this->update([
            'tanggal_selesai' => now()
        ]);
    }

    public function getSuratJalanFileWithFulPath()
    {
        return storage_path(self::SURAT_JALAN_FILE_PATH . '/' . $this->surat_jalan_file);
    }
}

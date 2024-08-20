<?php

namespace App\Models;

use Contracts\DTOs\Domain\Enum\StatusPengajuanPembelian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPembelian extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pembelian';

    protected $fillable = [
        'nomor_pengajuan',
        'tanggal_pengajuan',
        'staf_pengaju_id',
        'gudang_pengaju_id',
        'status_pengajuan'
    ];

    public function approve()
    {
        $this->status_pengajuan = StatusPengajuanPembelian::DITERIMA;
        $this->save();
    }

    public function reject()
    {
        $this->status_pengajuan = StatusPengajuanPembelian::DITOLAK;
        $this->save();
    }

    public function stafPengaju()
    {
        return $this->belongsTo(Staf::class, 'staf_pengaju_id');
    }
}

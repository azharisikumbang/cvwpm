<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPembelian extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_pembelian';

    const STATUS_PENDING = 'pending';

    const STATUS_APPROVED = 'approved';

    const STATUS_REJECTED = 'rejected';

    const STATU_REVISED = 'revised';

    protected $fillable = [
        'status',
        'catatan',
        'created_by',
    ];

    protected $appends = [
        'status_label',
        'status_color',
        'tanggal_pengajuan',
        'total_dus',
        'total_kotak',
        'total_barang',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->status = self::STATUS_PENDING;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function details()
    {
        return $this->hasMany(PengajuanPembelianDetail::class);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status)
        {
            self::STATUS_PENDING => 'Diajukan Ke Purchasing',
            self::STATUS_APPROVED => 'Diterima',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATU_REVISED => 'Direvisi',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status)
        {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_APPROVED => 'green',
            self::STATUS_REJECTED => 'red',
            self::STATU_REVISED => 'info',
            default => 'gray',
        };
    }

    public function getTanggalPengajuanAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function getTotalDusAttribute()
    {
        return $this->details->sum('jumlah_dus');
    }

    public function getTotalKotakAttribute()
    {
        return $this->details->sum('jumlah_kotak');
    }

    public function getTotalBarangAttribute()
    {
        return $this->details->count();
    }
}

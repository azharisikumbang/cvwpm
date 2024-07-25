<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PurchaseOrder extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';

    const STATUS_SELESAI = 'selesai';

    protected $fillable = [
        'nomor',
        'tanggal',
        'status',
        'staf_id',
        'gudang_id',
    ];

    protected $appends = [
        'jumlah_kotak',
        'jumlah_dus',
        'total_item'
    ];

    public function riwayatStok(): MorphMany
    {
        return $this->morphMany(RiwayatStok::class, 'stokable');
    }

    public function staf(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staf_id');
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class);
    }

    public function getJumlahKotakAttribute(): int
    {
        return $this->riwayatStok->sum('jumlah_kotak');
    }

    public function getJumlahDusAttribute(): int
    {
        return $this->riwayatStok->sum('jumlah_dus');
    }

    public function getTotalItemAttribute(): int
    {
        return $this->riwayatStok->count();
    }
}

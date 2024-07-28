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

    const STATUS_PENDING = 'Pending';

    const STATUS_SELESAI = 'Lunas';

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
        'total_item',
        'is_done'
    ];

    public function riwayatStok(): MorphMany
    {
        return $this
            ->morphMany(RiwayatStok::class, 'stokable')
            ->orderBy('barang_id');
    }

    public function staf(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staf_id');
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class);
    }

    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class);
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

    public function markAsComplete()
    {
        $this->status = self::STATUS_SELESAI;
        $this->save();
    }

    public function getIsDoneAttribute()
    {
        if ($this->status == self::STATUS_SELESAI)
            return true;

        $totalPO = $this->riwayatStok->sum('jumlah_dus') + $this->riwayatStok->sum('jumlah_kotak');

        $totalDO = $this->deliveryOrders->sum(function (DeliveryOrder $deliveryOrder) {
            return $deliveryOrder->riwayatStok->sum('jumlah_dus');
        });

        return $totalDO >= $totalPO;
    }
}

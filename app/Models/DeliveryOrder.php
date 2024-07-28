<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DeliveryOrder extends Model
{
    use HasFactory;

    const STATUS_ALL = 'DONE';

    const STATUS_PARTIAL = 'PARTIAL';

    protected $fillable = [
        'nomor',
        'tanggal_penerimaan',
        'purchase_order_id',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function riwayatStok(): MorphMany
    {
        return $this->morphMany(RiwayatStok::class, 'stokable');
    }

    public function markAsComplete()
    {
        $this->status = self::STATUS_ALL;
        $this->save();
    }
}

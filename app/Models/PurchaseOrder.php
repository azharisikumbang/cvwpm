<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory;

    // status po
    const STATUS_PENDING = 'pending'; // oleh admin stok

    const STATUS_APPROVED = 'approved'; // oleh admin purchasing

    const STATUS_REJECTED = 'rejected'; // oleh manajer

    const STATU_REVISED = 'revised'; // oleh admin purchasing

    // status pengajuan
    const STATUS_DRAFT = 'draft'; // pengajuan admin stok

    const STATUS_SUBMITTED = 'submitted'; // pengajuan oleh admin purchasing


    protected $fillable = [
        'nomor',
        'tanggal',
        'status',
        'staf_id',
        'supplier'
    ];

    public $incrementing = false;

    protected $primaryKey = 'nomor';

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isRevised(): bool
    {
        return $this->status === self::STATU_REVISED;
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isSubmitted(): bool
    {
        return $this->status === self::STATUS_SUBMITTED;
    }

    public function approve(): void
    {
        $this->update(['status' => self::STATUS_APPROVED]);
    }

    public function reject(): void
    {
        $this->update(['status' => self::STATUS_REJECTED]);
    }

    public function revise(): void
    {
        $this->update(['status' => self::STATU_REVISED]);
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseOrderDetails::class, 'nomor_po', 'nomor');
    }
}

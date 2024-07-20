<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_po',
        'barang_id',
        'jumlah_dus',
        'jumlah_kotak'
    ];

    public $incrementing = false;

    protected $primaryKey = ['nomor_po', 'barang_id']; // composite

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('nomor_po', '=', $this->getAttribute('nomor_po'))
            ->where('barang_id', '=', $this->getAttribute('barang_id'));

        return $query;
    }
}

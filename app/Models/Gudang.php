<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;

    protected $table = 'gudang';

    protected $fillable = [
        'kode_gudang',
        'nama',
        'lokasi',
        'penanggung_jawab',
    ];

    protected $appends = [
        'pic',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($gudang) {
            $gudang->kode_gudang = trim(strtoupper($gudang->kode_gudang));
        });
    }

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(Staf::class, 'penanggung_jawab');
    }

    public function getPicAttribute()
    {
        return $this->penanggungJawab ? sprintf("%s (%s)", $this->penanggungJawab->nama, $this->penanggungJawab->kontak) : 'Tidak ada PIC';
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function stafs()
    {
        return $this->hasMany(Staf::class, 'gudang_kerja');
    }

    public function sales()
    {
        return $this->stafs()->where(
            'jabatan',
            Role::find(Role::ID_SALES)->getDisplaybleName()
        );
    }
}

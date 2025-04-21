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
            $gudang->kode_gudang = str_replace
            (
                " ",
                "_",
                trim(strtoupper($gudang->kode_gudang))
            );
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
        $staf = $this->stafs()->where('jabatan', Role::where('id', Role::ID_ADMIN_STOCK)->first()->getDisplaybleName())->first(['nama', 'kontak']);

        if (is_null($staf))
            return "Tidak Ada PIC";

        return sprintf("%s (%s)", $staf->nama, $staf->kontak);
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

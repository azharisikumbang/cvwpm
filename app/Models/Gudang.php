<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;

    protected $table = 'gudang';

    protected $fillable = [
        'nama',
        'lokasi',
        'penanggung_jawab',
    ];

    protected $appends = [
        'pic',
    ];

    public function penanggungJawab()
    {
        return $this->belongsTo(Staf::class, 'penanggung_jawab');
    }

    public function getPicAttribute()
    {
        return $this->penanggungJawab ? sprintf("%s (%s)", $this->penanggungJawab->nama, $this->penanggungJawab->kontak) : 'Tidak ada PIC';
    }
}

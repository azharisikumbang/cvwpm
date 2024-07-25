<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staf extends Model
{
    use HasFactory;

    protected $table = 'staf';

    protected $fillable = [
        'nama',
        'kontak',
        'jabatan',
        'gudang_kerja',
        'user_id'
    ];

    protected $appends = [
        'gudang_kerja_text'
    ];

    public function gudangKerja()
    {
        return $this->belongsTo(Gudang::class, 'gudang_kerja');
    }

    public function cekKepemilikanGudangKerja(Gudang $gudang): bool
    {
        return $gudang->penanggungJawab->id === $this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getGudangKerjaTextAttribute(): string
    {
        return $this->gudangKerja->nama;
    }
}

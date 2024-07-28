<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama',
        'gudang_id',
        'kemasan',
        'harga',
        'satuan',
        'jumlah_dus',
        'jumlah_satuan',
        'jumlah_kotak',
        'satuan_per_dus',
        'satuan_per_kotak',
        'kode_barang'
    ];

    protected $appends = [
        'harga_rupiah',
        'nama_kemasan',
        'jumlah_text',
    ];

    public function getHargaRupiahAttribute()
    {
        return 'Rp. ' . number_format($this->harga, 0, ',', '.');
    }

    public function getHargaAttribute($value)
    {
        return (int) $value;
    }

    public function getNamaKemasanAttribute()
    {
        return $this->nama . ' ' . $this->kemasan;
    }

    public function getJumlahTextAttribute()
    {
        return $this->jumlah_dus . ' dus, ' . $this->jumlah_kotak . ' kotak, ' . $this->jumlah_satuan . ' ' . $this->satuan;
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function validateGudang()
    {
        return $this->gudang_id === auth()->user()->staf->gudangKerja->id;
    }

    public function getBarangGudang()
    {
        return $this->where('gudang_id', auth()->user()->staf->gudangKerja->id)->get();
    }

    public function riwayatStok()
    {
        return $this->hasMany(RiwayatStok::class);
    }

    public function kurangiStok(
        int $jumlahDus,
        int $jumlahKotak,
        int $jumlahSatuan
    ) {
        $this->jumlah_dus -= $jumlahDus;
        $this->jumlah_kotak -= $jumlahKotak;
        $this->jumlah_satuan -= $jumlahSatuan;
        $this->save();
    }

    public function tambahStok(int $jumlahDus, int $jumlahKotak, int $jumlahSatuan)
    {
        // jumlah dus = jumlah dus masuk + jumlah dus yang ada
        $this->jumlah_kotak += $jumlahKotak;

        // jumlah kotak = jumlah kotak masuk + jumlah kotak yang ada
        $this->jumlah_dus += $jumlahDus;

        // jumlah pcs = (dus * pcs per dus) + (kotak * pcs per kotak) + jumlah pcs yang ada
        $pcsMasuk = $jumlahDus * $this->satuan_per_dus + $jumlahKotak * $this->satuan_per_kotak;
        $this->jumlah_satuan += $pcsMasuk + $jumlahSatuan;

        $this->save();
    }
}

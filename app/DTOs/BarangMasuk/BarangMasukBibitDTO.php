<?php

namespace App\DTOs\BarangMasuk;

use Contracts\DTOs\Domain\BarangDTO;
use Contracts\DTOs\Domain\BarangMasuk\BarangMasukBibitDTOInterface;

class BarangMasukBibitDTO implements BarangMasukBibitDTOInterface
{
    public function __construct(
        protected readonly int|BarangDTO $barang,
        protected readonly int $jumlahKotak,
        protected readonly int $jumlahDus,
        protected readonly int $jumlahSatuan
    ) {
        # code...
    }

    public function getBarang(): int|BarangDTO
    {
        return $this->barang;
    }

    public function getJumlahKotak(): int
    {
        return $this->jumlahKotak;
    }

    public function getJumlahDus(): int
    {
        return $this->jumlahDus;
    }

    public function getJumlahSatuan(): int
    {
        return $this->jumlahSatuan;
    }
}
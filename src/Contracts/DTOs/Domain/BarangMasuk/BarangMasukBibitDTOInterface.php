<?php

namespace Contracts\DTOs\Domain\BarangMasuk;

interface BarangMasukBibitDTOInterface extends BarangMasukDTOInterface
{
    public function getJumlahKotak(): int;

    public function getJumlahDus(): int;

    public function getJumlahSatuan(): int;
}
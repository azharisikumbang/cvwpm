<?php

namespace Contracts\DTOs\Domain;

interface BarangBibitDTO extends BarangDTO
{
    public function getJumlahDus(): int;

    public function getJumlahKotak(): int;

    public function getJumlahSatuan(): int;

}
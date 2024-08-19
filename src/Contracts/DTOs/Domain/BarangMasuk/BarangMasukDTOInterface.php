<?php

namespace Contracts\DTOs\Domain\BarangMasuk;

use Contracts\DTOs\Domain\BarangDTO;

interface BarangMasukDTOInterface
{
    public function getBarang(): int|BarangDTO;
}
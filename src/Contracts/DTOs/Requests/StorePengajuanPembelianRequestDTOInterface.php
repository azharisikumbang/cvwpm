<?php

namespace Contracts\DTOs\Requests;

use Contracts\DTOs\Domain\Enum\JenisBarangEnum;

interface StorePengajuanPembelianRequestDTOInterface
{
    public function getType(): JenisBarangEnum;

    /**
     * @return array<array{id: int, kotak: int, dus: int, satuan: int|null}>
     */
    public function getBarang(): array;
}
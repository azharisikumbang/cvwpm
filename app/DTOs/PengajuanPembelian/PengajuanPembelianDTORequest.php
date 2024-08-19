<?php

namespace App\DTOs\PengajuanPembelian;

use Contracts\DTOs\Domain\Enum\JenisBarangEnum;
use Contracts\DTOs\Requests\StorePengajuanPembelianRequestDTOInterface;

class PengajuanPembelianDTORequest implements StorePengajuanPembelianRequestDTOInterface
{
    public JenisBarangEnum $type;
    public array $barang;

    public function __construct(JenisBarangEnum $type, array $barang)
    {
        $this->type = $type;
        $this->barang = $barang;
    }

    public function getType(): JenisBarangEnum
    {
        return $this->type;
    }

    public function getBarang(): array
    {
        return $this->barang;
    }
}
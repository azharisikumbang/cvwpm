<?php

namespace App\DTOs\PengajuanPembelian;
use Contracts\DTOs\Requests\IndexPengajuanPembelianRequestDTOInterface;

final class IndexPengajuanPembelianDTORequest implements IndexPengajuanPembelianRequestDTOInterface
{
    public function __construct(
        private int $stafPengajuId,
        private int $limit = 10,
        private int $offset = 1
    ) {
        //
    }

    public function getStafPengajuId(): int
    {
        return $this->stafPengajuId;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
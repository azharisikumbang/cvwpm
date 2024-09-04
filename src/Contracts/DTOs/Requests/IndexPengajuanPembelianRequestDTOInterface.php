<?php

namespace Contracts\DTOs\Requests;

interface IndexPengajuanPembelianRequestDTOInterface
{
    public function getStafPengajuId(): int;
    public function getLimit(): int;
    public function getOffset(): int;
}
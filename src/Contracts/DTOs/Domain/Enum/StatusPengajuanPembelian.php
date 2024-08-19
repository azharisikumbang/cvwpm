<?php

namespace Contracts\DTOs\Domain\Enum;

enum StatusPengajuanPembelian: string
{
    case DRAFT = 'DRAFT';
    case DIAJUKAN = 'DIAJUKAN';
    case DITOLAK = 'DITOLAK';
    case DITERIMA = 'DITERIMA';
}
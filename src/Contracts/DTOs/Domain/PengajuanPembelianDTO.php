<?php

namespace Contracts\DTOs\Domain;

use Contracts\DTOs\Domain\Enum\StatusPengajuanPembelian;
use Contracts\DTOs\Domain\BarangMasuk\BarangMasukDTOInterface;
use DateTimeInterface;

interface PengajuanPembelianDTO
{
    public function getNomorPengajuan(): string;

    public function getTanggalPengajuan(): DateTimeInterface;

    public function getStafPengaju(): StafDTO;

    public function getGudangPengaju(): GudangDTO;

    public function getStatusPengajuan(): StatusPengajuanPembelian;

    /**
     * @return BarangMasukDTOInterface[]
     */
    public function getListBarang(): array;
}
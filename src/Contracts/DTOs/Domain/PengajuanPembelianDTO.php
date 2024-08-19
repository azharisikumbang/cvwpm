<?php

namespace Contracts\DTOs\Domain;

use Contracts\DTOs\Domain\Enum\StatusPengajuanPembelian;
use DateTimeInterface;

interface PengajuanPembelianDTO
{

    public function getNomorPengajuan(): string;

    public function getTanggalPengajuan(): DateTimeInterface;

    public function getStafPengaju(): StafDTO;

    public function getGudangPengaju(): GudangDTO;

    public function getStatusPengajuan(): StatusPengajuanPembelian;

    /**
     * @return BarangDTO[]
     */
    public function getListBarang(): array;
}
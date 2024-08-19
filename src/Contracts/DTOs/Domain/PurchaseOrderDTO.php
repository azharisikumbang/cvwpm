<?php

namespace Contracts\DTOs\Domain;

use Contracts\DTOs\Domain\Enum\StatusPurchaseOrder;

interface PurchaseOrderDTO
{

    public function getNomorPurchaseOrder(): string;

    public function getTanggalPurchaseOrder(): DateTimeInterface;

    public function getPengejuanPembelian(): PengajuanPembelianDTO;

    public function getStafPembuat(): StafDTO;

    public function getGudangPembuat(): GudangDTO;

    public function getStatusPurchaseOrder(): StatusPurchaseOrder;

    /**
     * @return BarangDTO[]
     */
    public function getListBarang(): array;
}
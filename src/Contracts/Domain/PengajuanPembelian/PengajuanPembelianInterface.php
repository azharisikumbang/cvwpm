<?php

namespace Contracts\Domain\PengajuanPembelian;

use Contracts\DTOs\Domain\BarangDTO;
use Contracts\DTOs\Domain\PengajuanPembelianDTO;
use Contracts\DTOs\Requests\StorePengajuanPembelianRequestDTOInterface;

/**
 * Pengejuan pembelian adalah aktivitas awalan untuk melakukan pembelian barang
 * yang dilakukan oleh admin stok kepada admin purchasing
 * setiap pengajuan pembelian perlu diperiksa oleh admin purchasing
 * sebelum akhir berubah menjadi purchase order
 * 
 * Setiap pengejuan pembelian harus memiliki nomor Pengajuan Pembelian dan unik
 * serta memiliki dokumen pengajuan pembelian dalam bentuk PDF
 * 
 */
interface PengajuanPembelianInterface
{
    public function cari(string $nomor): PengajuanPembelianDTO;

    public function simpan(StorePengajuanPembelianRequestDTOInterface $data): void;

    public function tambahBarang(BarangDTO $barang): self;

    public function simpanDokumenPDF(): void;

    public function approve(): void;

    public function reject(): void;

    public function getNomorPengajuanPembelian(): string;

    /**
     * @return BarangDTO[]
     */
    public function getBarang(): array;

    /**
     * path atau lokasi lengkap dokumen pengajuan pembelian
     * 
     * @return string
     */
    public function getDokumenPengajuanPembelian(): string;
}
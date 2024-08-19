<?php

namespace Contracts\DTOs\Domain;

/**
 * Sistem penghitungan jumlah barang menggunakan satuan dus, kotak, dan satuan
 * Stok terbagi ke dalam dua stok gudang dan stok canvas
 * Gabungan antar stok gudang dan stok canvas adalah stok total
 * 
 * Stok akan diperbaharui setiap terjadi barang masuk atau barang keluar
 * 
 * Interface BarangBibitDTO
 * @package Contracts\DTOs\Domain
 */
interface BarangBibitDTO extends BarangDTO
{
    public function getKemasan(): string;

    public function getJumlahDusGudang(): int;

    public function getJumlahKotakGudang(): int;

    public function getJumlahSatuanGudang(): int;

    public function getJumlahDusCanvas(): int;

    public function getJumlahKotakCanvas(): int;

    public function getJumlahSatuanCanvas(): int;
}
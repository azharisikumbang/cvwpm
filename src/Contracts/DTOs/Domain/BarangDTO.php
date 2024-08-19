<?php

namespace Contracts\DTOs\Domain;

interface BarangDTO
{
    public function getId(): int;

    public function getKodeBarang(): string;

    public function getNamaBarang(): string;

    public function getHargaBeliBarang(): float;

    public function getHargaJualBarang(): float;

    public function getMarginProfitBarang(): float;

    public function getStokBarangDalamSatuan(): int;

    public function getNamaSatuanTerkecil(): int;

    public function getJenisBarang(): JenisBarangEnum;

    public function getGudang(): GudangDTO;
}
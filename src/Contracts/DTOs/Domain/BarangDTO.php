<?php

namespace Contracts\DTOs\Domain;

interface BarangDTO
{
    public function getKodeBarang(): string;

    public function getNamaBarang(): string;

    public function getKemasanBarang(): string;

    public function getHargaBeliBarang(): float;

    public function getHargaJualBarang(): float;

    public function getMarginProfitBarang(): float;

    public function getStokBarang(): int;

    public function getNamaSatuanTerkecil(): int;
}
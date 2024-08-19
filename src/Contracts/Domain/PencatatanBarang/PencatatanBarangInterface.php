<?php

namespace Contracts\Domain\PencatatanBarang;

interface PencatatanBarangInterface
{

    public function generateKodeBarang(): string;

    public function simpan(): void;

    public function tambahStok();

    public function kurangiStok();
}
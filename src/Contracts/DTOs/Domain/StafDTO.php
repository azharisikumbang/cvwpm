<?php

namespace Contracts\DTOs\Domain;


interface StafDTO
{
    public function getKodeStaf(): string;

    public function getNamaStaf(): string;

    public function getJabatanStaf(): string;

    public function getNomorTeleponStaf(): string;

    public function getGudangKerja(): GudangDTO;

}
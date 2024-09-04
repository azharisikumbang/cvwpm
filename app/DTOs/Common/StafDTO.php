<?php

namespace App\DTOs\Common;

use App\Models\Staf;
use Contracts\DTOs\Domain\GudangDTO as GudangDTOContract;
use Contracts\DTOs\Domain\StafDTO as StafDTOContract;

final class StafDTO implements StafDTOContract
{
    public function __construct(
        private readonly int $id,
        private readonly string $kodeStaf,
        private readonly string $namaStaf,
        private readonly string $jabatanStaf,
        private readonly string $nomorTeleponStaf,
        private readonly GudangDTOContract $gudangKerja
    ) {
        # code...
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getKodeStaf(): string
    {
        return $this->kodeStaf;
    }

    public function getNamaStaf(): string
    {
        return $this->namaStaf;
    }

    public function getJabatanStaf(): string
    {
        return $this->jabatanStaf;
    }

    public function getNomorTeleponStaf(): string
    {
        return $this->nomorTeleponStaf;
    }

    public function getGudangKerja(): GudangDTO
    {
        return $this->gudangKerja;
    }

    public static function fromModel(Staf $staf): StafDTO
    {
        return new self(
            id: $staf->id,
            kodeStaf: $staf->kode ?? '-',
            namaStaf: $staf->nama,
            jabatanStaf: $staf->jabatan,
            nomorTeleponStaf: $staf->kontak,
            gudangKerja: GudangDTO::fromModel($staf->gudangKerja)
        );
    }
}
<?php

namespace App\DTOs\Common;

use App\Models\Gudang;
use Contracts\DTOs\Domain\GudangDTO as GudangDTOContract;

final class GudangDTO implements GudangDTOContract
{
    public function __construct(
        private readonly int $id,
        private readonly string $kodeGudang,
        private readonly string $namaGudang,
        private readonly string $lokasiGudang,
        private readonly string $penanggungJawabGudang,
        private readonly string $nomorTeleponPenganggunJawabGudang,
    ) {
        # code...
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getKodeGudang(): string
    {
        return $this->kodeGudang;
    }

    public function getNamaGudang(): string
    {
        return $this->namaGudang;
    }

    public function getLokasiGudang(): string
    {
        return $this->lokasiGudang;
    }

    public function getPenanggungJawabGudang(): string
    {
        return $this->penanggungJawabGudang;
    }


    public function getNomorTeleponPenanggungJawab(): string
    {
        return $this->nomorTeleponPenganggunJawabGudang;
    }

    public static function fromModel(Gudang $model)
    {
        return new self(
            id: $model->id,
            kodeGudang: $model->kode_gudang,
            namaGudang: $model->nama,
            lokasiGudang: $model->lokasi,
            penanggungJawabGudang: $model->penganggungJawab ? $model->penganggungJawab->nama : '',
            nomorTeleponPenganggunJawabGudang: $model->penganggungJawab ? $model->penganggungJawab->kontak : '',
        );
    }
}
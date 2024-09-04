<?php

namespace App\DTOs;

use App\DTOs\Common\StafDTO;
use App\Http\Requests\StorePengajuanPembelianRequest;
use App\Models\PengajuanPembelian;
use Contracts\DTOs\Domain\BarangDTO;
use Contracts\DTOs\Domain\Enum\StatusPengajuanPembelian;
use Contracts\DTOs\Domain\GudangDTO;
use Contracts\DTOs\Domain\PengajuanPembelianDTO as PengajuanPembelianDTOContract;
use DateTimeInterface;

final class PengajuanPembelianDTO implements PengajuanPembelianDTOContract
{
    private string $nomorPengajuan;

    private DateTimeInterface $tanggalPengajuan;

    private StafDTO $stafPengaju;

    private GudangDTO $gudangPengaju;

    private StatusPengajuanPembelian $statusPengajuan;

    /**
     * @var \Contracts\DTOs\Domain\BarangMasuk\BarangMasukDTOInterface[]
     */
    private array $listBarang;

    public function __construct(
        string $nomorPengajuan,
        DateTimeInterface $tanggalPengajuan,
        StafDTO $stafPengaju,
        GudangDTO $gudangPengaju,
        StatusPengajuanPembelian $statusPengajuan,
        array $listBarang = []
    ) {
        $this->nomorPengajuan = $nomorPengajuan;
        $this->tanggalPengajuan = $tanggalPengajuan;
        $this->stafPengaju = $stafPengaju;
        $this->gudangPengaju = $gudangPengaju;
        $this->statusPengajuan = $statusPengajuan;
        $this->listBarang = $listBarang;
    }

    public function getNomorPengajuan(): string
    {
        return $this->nomorPengajuan;
    }

    public function getTanggalPengajuan(): DateTimeInterface
    {
        return $this->tanggalPengajuan;
    }

    public function getStafPengaju(): StafDTO
    {
        return $this->stafPengaju;
    }

    public function getGudangPengaju(): GudangDTO
    {
        return $this->gudangPengaju;
    }

    public function getStatusPengajuan(): StatusPengajuanPembelian
    {
        return $this->statusPengajuan;
    }

    /**
     * @return BarangDTO[]
     */
    public function getListBarang(): array
    {
        return $this->listBarang;
    }

    public function setNomorPengajuan(string $nomorPengajuan): void
    {
        $this->nomorPengajuan = $nomorPengajuan;
    }

    public static function fromModel(PengajuanPembelian $model): static
    {
        $model->load('stafPengaju.gudangKerja', 'riwayatStok');

        $stafDTO = StafDTO::fromModel($model->stafPengaju);
        $gudangDTO = $stafDTO->getGudangKerja();

        return new static(
            nomorPengajuan: $model->nomor_pengajuan,
            tanggalPengajuan: $model->tanggal_pengajuan,
            stafPengaju: $stafDTO,
            gudangPengaju: $gudangDTO,
            statusPengajuan: StatusPengajuanPembelian::from($model->status_pengajuan),
            listBarang: $model->riwayatStok->map(fn($riwayatStok) => BarangDTO::fromModel($riwayatStok->stokable))->toArray()
        );
    }

    public static function fromRequest(StorePengajuanPembelianRequest $request): static
    {
        return new static(

        );
    }
}

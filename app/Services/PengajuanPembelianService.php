<?php

namespace App\Services;

use App\DTOs\PengajuanPembelianDTO;
use App\Models\PengajuanPembelian;
use App\Models\RiwayatStok;
use App\Models\RiwayatStokBibit;
use Contracts\Domain\PengajuanPembelian\PengajuanPembelianInterface;
use Contracts\DTOs\Domain\BarangDTO;
use Contracts\DTOs\Domain\BarangMasuk\BarangMasukBibitDTOInterface;
use Contracts\DTOs\Domain\BarangMasuk\BarangMasukDTOInterface;
use Contracts\DTOs\Domain\Enum\StatusPengajuanPembelian; // TODO: implementasi dari App
use Contracts\DTOs\Domain\Enum\JenisBarangEnum; // TODO: implementasi dari App
use Contracts\DTOs\Domain\PengajuanPembelianDTO as PengajuanPembelianDTOConctract; // TODO: change naming convention
use Contracts\DTOs\Requests\StorePengajuanPembelianRequestDTOInterface;
use Illuminate\Support\Facades\DB;

class PengajuanPembelianService implements PengajuanPembelianInterface
{
    const DOKUMEN_PENGAJUAN_PEMBELIAN_PATH = 'private/dokumen/pengajuan-pembelian';

    public function __construct(

    ) {
        //
    }

    public function cari(string $nomor): PengajuanPembelianDTOConctract
    {
        $result = PengajuanPembelian::where('nomor', $nomor)->firstOrFail();

        return PengajuanPembelianDTO::fromModel($result);
    }
    public function simpan(StorePengajuanPembelianRequestDTOInterface $dto): void
    {
        DB::transaction(function () use ($dto) {
            $pengajuanPembelian = PengajuanPembelian::create([
                'nomor_pengajuan' => $this->generateNomorPengajuanPembelian(),
                'tanggal_pengajuan' => now(),
                'staf_pengaju_id' => auth()->user()->staf->id,
                'status_pengajuan' => StatusPengajuanPembelian::DRAFT,
            ]);

            $this->simpanRiwayatStokBarang(
                $pengajuanPembelian,
                $dto
            );
        });
    }

    private function simpanRiwayatStokBarang(
        PengajuanPembelian $model,
        StorePengajuanPembelianRequestDTOInterface $request
    ): void {
        foreach ($request->getBarang() as $barang)
        {
            if (!$barang instanceof BarangMasukDTOInterface)
                throw new \Exception('Barang harus merupakan instance dari BarangMasukDTOInterface', 500);

            /** @var BarangMasukDTOInterface $barang */
            $riwayatStok = match ($request->getType())
            {
                JenisBarangEnum::BIBIT => $this->simpanRiwayatStokBarangBibit($model, $barang),
                default => throw new \Exception('Jenis barang tidak dikenal', 500),
            };

            $riwayatStok->stokable()->save($model);
        }
    }

    private function simpanRiwayatStokBarangBibit(
        PengajuanPembelian $pengajuanPembelian,
        BarangMasukBibitDTOInterface $barang
    ): RiwayatStok {
        $detail = RiwayatStokBibit::create([
            'kotak' => $barang->getJumlahKotak(),
            'dus' => $barang->getJumlahDus(),
            'satuan' => $barang->getJumlahSatuan(),
        ]);

        $riwayatStok = RiwayatStok::create([
            'riwayatable_id' => $pengajuanPembelian->id,
            'riwayatable_type' => PengajuanPembelian::class,
            'stokable_id' => $detail->id,
            'stokable_type' => RiwayatStokBibit::class,
            'barang_id' => is_int($barang->getBarang()) ? $barang->getBarang() : $barang->getBarang()->getId(),
        ]);

        $riwayatStok->riwayatable()->save($pengajuanPembelian);

        return $riwayatStok;
    }

    private function generateNomorPengajuanPembelian(): string
    {
        // TODO: implement this method
        return 'PPB-' . now()->format('Ymd') . '-' . rand(100, 999);
    }

    public function tambahBarang(BarangDTO $barang): self
    {

    }
    public function simpanDokumenPDF(): void
    {

    }

    public function approve(): void
    {

    }

    public function reject(): void
    {

    }

    public function getNomorPengajuanPembelian(): string
    {

    }

    /**
     * @return BarangDTO[]
     */
    public function getBarang(): array
    {

    }

    /**
     * path atau lokasi lengkap dokumen pengajuan pembelian
     * 
     * @return string
     */
    public function getDokumenPengajuanPembelian(): string
    {

    }
}

<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\PindahGudang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PencatatanBarangMasukPindahGudangTest extends TestCase
{
    use RefreshDatabase;

    public function testPencatatanBarangMasukSecataOtomatis()
    {
        $this->withoutExceptionHandling();

        $adminStok = $this->asAdminStock();
        $this->setUpGudangAndStaf($adminStok);

        $gudangTujuan = Gudang::factory()->create();

        $satuanPerDus = 100;
        $satuanPerKotak = 10;
        Barang::factory()->createMany([
            [
                'nama' => 'Barang 1',
                'kemasan' => 'Kotak',
                'gudang_id' => 1,
                'jumlah_dus' => 100,
                'jumlah_kotak' => 30,
                'satuan_per_dus' => $satuanPerDus,
                'satuan_per_kotak' => $satuanPerKotak,
                'jumlah_satuan' => ($satuanPerDus * 100) + ($satuanPerKotak * 30),
            ],
            [
                'nama' => 'Barang 2',
                'kemasan' => 'Kotak',
                'gudang_id' => 1,
                'jumlah_dus' => 50,
                'jumlah_kotak' => 50,
                'satuan_per_dus' => $satuanPerDus,
                'satuan_per_kotak' => $satuanPerKotak,
                'jumlah_satuan' => ($satuanPerDus * 50) + ($satuanPerKotak * 50),
            ],
        ]);

        $pindahGudangAsal = PindahGudang::factory()->create([
            'nomor_surat_jalan' => 'SJ-001',
            'gudang_tujuan_id' => 2,
            'gudang_asal_id' => 1,
            'tanggal_pemindahan' => '2021-01-01',
            'jenis_pindah_gudang' => PindahGudang::PINDAH_KELUAR,
        ]);

        $pindahGudangAsal->riwayatStok()->create([
            'barang_id' => 1,
            'jumlah_dus' => 50,
            'jumlah_kotak' => 10,
            'jumlah_satuan' => 0,
        ]);

        $pindahGudangAsal->riwayatStok()->create([
            'barang_id' => 2,
            'jumlah_dus' => 10,
            'jumlah_kotak' => 5,
            'jumlah_satuan' => 0,
        ]);

        $response = $this->post(route('admin-stock.pindah-gudang-tujuan.store', $pindahGudangAsal->id));
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('pindah_gudang', [
            'nomor_surat_jalan' => $pindahGudangAsal->nomor_surat_jalan,
            'gudang_asal_id' => 1,
            'gudang_tujuan_id' => 2,
            'tanggal_pemindahan' => '2021-01-01',
            'tanggal_penyelesaian' => now(),
            'jenis_pindah_gudang' => PindahGudang::PINDAH_MASUK,
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'stokable_id' => 2,
            'stokable_type' => PindahGudang::class,
            'barang_id' => 3,
            'jumlah_dus' => 50,
            'jumlah_kotak' => 10,
            'jumlah_satuan' => 0,
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'stokable_id' => 2,
            'stokable_type' => PindahGudang::class,
            'barang_id' => 4,
            'jumlah_dus' => 10,
            'jumlah_kotak' => 5,
            'jumlah_satuan' => 0,
        ]);

        $this->assertDatabaseHas('barang', [
            'gudang_id' => 2,
            'nama' => 'Barang 1',
            'kemasan' => 'Kotak',
            'jumlah_dus' => 50,
            'jumlah_kotak' => 10,
            'jumlah_satuan' => ($satuanPerDus * 50) + ($satuanPerKotak * 10),
        ]);

        $this->assertDatabaseHas('barang', [
            'gudang_id' => 2,
            'nama' => 'Barang 2',
            'kemasan' => 'Kotak',
            'jumlah_dus' => 10,
            'jumlah_kotak' => 5,
            'jumlah_satuan' => ($satuanPerDus * 10) + ($satuanPerKotak * 5),
        ]);
    }
}

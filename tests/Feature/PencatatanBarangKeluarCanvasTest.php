<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\SalesCanvas;
use App\Models\Staf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PencatatanBarangKeluarCanvasTest extends TestCase
{
    use RefreshDatabase;

    private function createDataGudangDanBarang()
    {
        $gudangs = Gudang::factory(10)->create();

        $gudangs->each(function ($gudang) {
            $gudang->barang()->createMany([
                ['nama' => 'Barang 1', 'jumlah_dus' => 100, 'jumlah_kotak' => 100, 'jumlah_satuan' => 100, 'kemasan' => 'pcs'],
                ['nama' => 'Barang 2', 'jumlah_dus' => 100, 'jumlah_kotak' => 100, 'jumlah_satuan' => 100, 'kemasan' => 'pcs'],
            ]);
        });
    }

    public function testPencatatanTersimpanPadaBasisData()
    {
        $adminStok = $this->asAdminStock();
        $this->setUpGudangAndStaf($adminStok);

        $sales = Staf::factory()->create(['nama' => 'Sales 1', 'gudang_kerja' => 1]);

        $satuanPerDus = 100;
        $satuanPerKotak = 10;
        Barang::factory()->createMany([
            [
                'gudang_id' => 1,
                'jumlah_dus' => 100,
                'jumlah_kotak' => 30,
                'satuan_per_dus' => $satuanPerDus,
                'satuan_per_kotak' => $satuanPerKotak,
                'jumlah_satuan' => ($satuanPerDus * 100) + ($satuanPerKotak * 30),
            ],
            [
                'gudang_id' => 1,
                'jumlah_dus' => 50,
                'jumlah_kotak' => 50,
                'satuan_per_dus' => $satuanPerDus,
                'satuan_per_kotak' => $satuanPerKotak,
                'jumlah_satuan' => ($satuanPerDus * 50) + ($satuanPerKotak * 50),
            ],
        ]);


        $request = [
            'sales' => $sales->id,
            'wilayah' => 'Padang Panjang, Batu Sangkar, Bukittinggi',
            'tanggal_mulai' => '2021-01-01',
            'barang' => [
                [
                    'id' => 1,
                    'jumlah_dus' => 50,
                    'jumlah_kotak' => 10,
                    'jumlah_satuan' => 0,
                ],
                [
                    'id' => 2,
                    'jumlah_dus' => 10,
                    'jumlah_kotak' => 5,
                    'jumlah_satuan' => 0
                ]
            ]
        ];

        $response = $this->post('/admin-stock/sales-canvas/create', $request);

        $response->assertRedirect('/admin-stock/sales-canvas/1');
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('sales_canvases', [
            'nomor_surat_jalan' => '2024/001',
            'sales_id' => $sales->id,
            'wilayah' => 'Padang Panjang, Batu Sangkar, Bukittinggi',
            'tanggal_mulai' => '2021-01-01',
            'tanggal_selesai' => null,
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 1,
            'jumlah_dus' => 50,
            'jumlah_kotak' => 10,
            'jumlah_satuan' => 0,
            'stokable_id' => 1,
            'stokable_type' => SalesCanvas::class,
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 2,
            'jumlah_dus' => 10,
            'jumlah_kotak' => 5,
            'jumlah_satuan' => 0,
            'stokable_id' => 1,
            'stokable_type' => SalesCanvas::class,
        ]);

        $this->assertDatabaseHas('barang', [
            'id' => 1,
            'gudang_id' => 1,
            'jumlah_dus' => 50, // 100 - 50
            'jumlah_kotak' => 20,
            'jumlah_satuan' => 10_300 - ($satuanPerDus * 50 + $satuanPerKotak * 10), // saldo - stok keluar
        ]);

        $this->assertDatabaseHas('barang', [
            'id' => 2,
            'gudang_id' => 1,
            'jumlah_dus' => 50 - 10, // saldo - keluar
            'jumlah_kotak' => 50 - 5, // saldo - keluar
            'jumlah_satuan' => 5_500 - ($satuanPerDus * 10 + $satuanPerKotak * 5), // saldo - stok keluar
        ]);


        // check berkas surat jalan disimpan
        // $this->assertFileExists(storage_path('app/private/surat-jalan-canvas/' . md5('2024/001') . '.pdf'));

        // clean up
        // unlink(storage_path('app/private/surat-jalan-canvas/' . md5('2024/001') . '.pdf'));
    }
}

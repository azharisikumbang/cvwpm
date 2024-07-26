<?php

namespace Tests\Feature;

use App\Models\Gudang;
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
        $this->asAdminStock();
        $this->createDataGudangDanBarang();

        $sales = Staf::factory()->create(['nama' => 'Sales 1', 'gudang_kerja' => 1]);

        $request = [
            'sales' => $sales->id,
            'wilayah' => 'Padang Panjang, Batu Sangkar, Bukittinggi',
            'tanggal_mulai' => '2021-01-01',
            'barang' => [
                [
                    'id' => 1,
                    'jumlah_dus' => 10,
                    'jumlah_kotak' => 0,
                    'jumlah_satuan' => 0,
                    'keterangan' => 'Barang 1'
                ],
                [
                    'id' => 2,
                    'jumlah_dus' => 0,
                    'jumlah_kotak' => 10,
                    'jumlah_satuan' => 0,
                    'keterangan' => null
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
            'jumlah_dus' => 10,
            'jumlah_kotak' => 0,
            'jumlah_satuan' => 0,
            'keterangan' => 'Barang 1',
            'stokable_id' => 1,
            'stokable_type' => 'App\Models\SalesCanvas',
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 2,
            'jumlah_dus' => 0,
            'jumlah_kotak' => 10,
            'jumlah_satuan' => 0,
            'keterangan' => null,
            'stokable_id' => 1,
            'stokable_type' => 'App\Models\SalesCanvas',
        ]);

        $this->assertDatabaseHas('barang', [
            'id' => 1,
            'gudang_id' => 1,
            'jumlah_dus' => 90, // 100 - 10
            'jumlah_kotak' => 100,
            'jumlah_satuan' => 100,
        ]);

        $this->assertDatabaseHas('barang', [
            'id' => 2,
            'gudang_id' => 1,
            'jumlah_dus' => 100,
            'jumlah_kotak' => 90, // 100 - 10
            'jumlah_satuan' => 100,
        ]);

        // check berkas surat jalan disimpan
        $this->assertFileExists(storage_path('app/public/surat-jalan-canvas/' . md5('2024/001') . '.pdf'));

        // clean up
        unlink(storage_path('app/public/surat-jalan-canvas/' . md5('2024/001') . '.pdf'));
    }
}

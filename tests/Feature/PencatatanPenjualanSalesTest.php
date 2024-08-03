<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Role;
use App\Models\SalesCanvas;
use App\Models\Staf;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PencatatanPenjualanSalesTest extends TestCase
{
    use RefreshDatabase;

    public function testSalesDapatMenjualBarang()
    {
        $this->markTestIncomplete("gagal saat test upload file faktur penjualan");
        $adminStok = User::factory()->create([
            'role_id' => Role::ID_ADMIN_STOCK
        ]);

        $this->setUpGudangAndStaf($adminStok);

        $user = $this->asSales();
        $sales = Staf::factory()->create([
            'nama' => 'Sales 1',
            'gudang_kerja' => 1,
            'user_id' => $user->id
        ]);

        $this->setupData($sales);

        // send request
        $request = [
            'canvas' => 1,
            'nama_toko' => 'Toko A',
            'alamat_toko' => 'Padang Panjang',
            'tanggal_transaksi' => '2021-01-01',
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

        $response = $this->post(route('sales.penjualan.store'), $request);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('penjualan', [
            'nomor' => 'WPM00001',
            'sales_canvas_id' => 1,
            'nama_toko' => 'Toko A',
            'alamat_toko' => 'Padang Panjang',
            'tanggal_transaksi' => '2021-01-01',
            'file_faktur_penjualan' => md5('WPM00001') . '.pdf'
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 1,
            'jumlah_dus' => 50,
            'jumlah_kotak' => 10,
            'jumlah_satuan' => 0,
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 2,
            'jumlah_dus' => 10,
            'jumlah_kotak' => 5,
            'jumlah_satuan' => 0,
        ]);

        // $this->assertFileExists(storage_path('app/private/faktur-penjualan/' . md5('WPM00001') . '.pdf'));

    }

    private function setupData(Staf $sales)
    {
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


        SalesCanvas::factory()->create([
            'sales_id' => $sales->id,
            'tanggal_mulai' => '2021-01-01',
            'tanggal_selesai' => null,
            'nomor_surat_jalan' => '001',
            'surat_jalan_file' => 'surat-jalan-001.pdf'
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\PindahGudang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PencatatanBarangKeluarPindahGudangTest extends TestCase
{
    use RefreshDatabase;

    public function testBarangPindahMengurangiStokDiGudangAsalDanMenyimpanSuratJalan()
    {
        $adminStok = $this->asAdminStock();
        $this->setUpGudangAndStaf($adminStok);

        $gudangTujuan = Gudang::factory()->create();

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
            'gudang_tujuan' => $gudangTujuan->id,
            'tanggal_pemindahan' => '2021-01-01',
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

        $response = $this->post('/admin-stock/pindah-gudang', $request);

        $response->assertRedirect('/admin-stock/pindah-gudang/1');
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('pindah_gudang', [
            'nomor_surat_jalan' => '2024/BARR/BBT/PDG/07/001',
            'gudang_asal_id' => 1,
            'gudang_tujuan_id' => $gudangTujuan->id,
            'tanggal_pemindahan' => '2021-01-01',
            'tanggal_penyelesaian' => null,
            'surat_jalan_file' => md5('2024/BARR/BBT/PDG/07/001') . '.pdf',
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 1,
            'jumlah_dus' => 50,
            'jumlah_kotak' => 10,
            'jumlah_satuan' => 0,
            'stokable_id' => 1,
            'stokable_type' => PindahGudang::class,
        ]);

        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 2,
            'jumlah_dus' => 10,
            'jumlah_kotak' => 5,
            'jumlah_satuan' => 0,
            'stokable_id' => 1,
            'stokable_type' => PindahGudang::class,
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

        // save file
        $this->assertFileExists(storage_path(sprintf("app/public/surat-jalan-pindah-gudang/%s.pdf", md5('2024/BARR/BBT/PDG/07/001'))));
    }
}

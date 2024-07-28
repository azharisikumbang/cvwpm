<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\DeliveryOrder;
use App\Models\PurchaseOrder;
use App\Models\RiwayatStok;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PenerimaanBarangPOTest extends TestCase
{
    use RefreshDatabase;

    public function testPenerimaanBarangPO()
    {
        $adminStok = $this->asAdminStock();
        $this->setUpGudangAndStaf($adminStok);

        $listBarang = Barang::factory(50)->create(['gudang_id' => 1]);

        $po = PurchaseOrder::factory()->create([
            'gudang_id' => 1,
            'staf_id' => $adminStok->id,
        ]);

        $barangRandom = $listBarang->random(10);

        $riwayatStok = $barangRandom->map(function (Barang $barang) use ($po) {
            return $po->riwayatStok()->create([
                'barang_id' => $barang->id,
                'jumlah_dus' => rand(10, 50),
                'jumlah_kotak' => rand(0, 5),
                'jumlah_satuan' => 0,
                'keterangan' => null,
            ]);
        });

        $requestBarang = $riwayatStok->map(function (RiwayatStok $barang) {
            return [
                'id' => $barang->barang_id,
                'jumlah_dus' => $barang->jumlah_dus,
                'jumlah_kotak' => $barang->jumlah_kotak,
                'jumlah_satuan' => 0
            ];
        });

        $request = [
            'nomor' => 'DO.001',
            'tanggal_penerimaan' => date('Y-m-d'),
            'barang' => $requestBarang->toArray()
        ];

        $response = $this->post(route('admin-stock.delivery-order.store', $po->id), $request);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();
        $response->assertSessionHas('success');

        $requestBarang->each(function ($barang, $index) use ($barangRandom) {
            // jumlah dus * pcs per kotak + jumlah kotak + pcs per kotak
            $masukPcsPerDus = $barang['jumlah_dus'] * $barangRandom[$index]->satuan_per_dus;
            $masukPcsPerKotak = $barang['jumlah_kotak'] * $barangRandom[$index]->satuan_per_kotak;
            $masukPcs = $masukPcsPerDus + $masukPcsPerKotak;

            $this->assertDatabaseHas('barang', [
                'gudang_id' => 1,
                'id' => $barang['id'],
                'jumlah_satuan' => $barangRandom[$index]->jumlah_satuan + $masukPcs,
                'jumlah_dus' => $barang['jumlah_dus'] + $barangRandom[$index]->jumlah_dus,
                'jumlah_kotak' => $barang['jumlah_kotak'] + $barangRandom[$index]->jumlah_kotak
            ]);

            $this->assertDatabaseHas('riwayat_stok', [
                'barang_id' => $barang['id'],
                'stokable_type' => DeliveryOrder::class,
                'jumlah_dus' => $barang['jumlah_dus'],
                'jumlah_kotak' => $barang['jumlah_kotak'],
                'jumlah_satuan' => $barang['jumlah_satuan']
            ]);
        });
    }
}

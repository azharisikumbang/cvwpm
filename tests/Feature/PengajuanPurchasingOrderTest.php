<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\PengajuanPembelian;
use App\Models\PengajuanPembelianDetail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PengajuanPurchasingOrderTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminPurchasingDapatMelihatHalamanPengajuanPurchasingOrder()
    {
        $this->asAdminPurchasing();

        Barang::factory(10)->create();
        $pengaju = User::factory()->create(['role_id' => Role::ID_ADMIN_STOCK]);
        $pengajuanPembelian = PengajuanPembelian::factory()->create([
            'created_by' => $pengaju->id
        ]);
        $pengajuanPembelian->details()->createMany([
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 1
            ])->toArray(),
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 2
            ])->toArray()
        ]);

        $this
            ->get(route('admin-purchasing.purchasing-orders.create', ['pengajuanPembelian' => $pengajuanPembelian->id]))
            ->assertOk();
    }

    public function testNonAdminPurchasingTidakDapatMelihatHalamanPengajuanPurchasingOrder()
    {
        $this->asAdminStock();

        Barang::factory(10)->create();
        $pengaju = User::factory()->create(['role_id' => Role::ID_ADMIN_STOCK]);
        $pengajuanPembelian = PengajuanPembelian::factory()->create([
            'created_by' => $pengaju->id
        ]);
        $pengajuanPembelian->details()->createMany([
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 1
            ])->toArray(),
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 2
            ])->toArray()
        ]);

        $this
            ->get(route('admin-purchasing.purchasing-orders.create', ['pengajuanPembelian' => $pengajuanPembelian->id]))
            ->assertStatus(403);
    }

    public function testPublicUsetTidakDapatMelihatHalamanPengajuanPurchasingOrder()
    {
        Barang::factory(10)->create();
        $pengaju = User::factory()->create(['role_id' => Role::ID_ADMIN_STOCK]);
        $pengajuanPembelian = PengajuanPembelian::factory()->create([
            'created_by' => $pengaju->id
        ]);
        $pengajuanPembelian->details()->createMany([
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 1
            ])->toArray(),
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 2
            ])->toArray()
        ]);

        $this
            ->get(route('admin-purchasing.purchasing-orders.create', ['pengajuanPembelian' => $pengajuanPembelian->id]))
            ->assertRedirect();
    }

    public function testPengajuanPO()
    {
        $this->asAdminPurchasing();

        Barang::factory(10)->create();
        $pengaju = User::factory()->create(['role_id' => Role::ID_ADMIN_STOCK]);
        $pengajuanPembelian = PengajuanPembelian::factory()->create([
            'created_by' => $pengaju->id
        ]);
        $pengajuanPembelian->details()->createMany([
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 1,
                'jumlah_kotak' => 1,
                'jumlah_dus' => 2,
            ])->toArray(),
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 2,
                'jumlah_kotak' => 2,
                'jumlah_dus' => 0,
            ])->toArray()
        ]);

        // test send data
        $response = $this->post(
            route('admin-purchasing.purchasing-orders.store', ['pengajuanPembelian' => $pengajuanPembelian->id]),
            [
                'supplier' => 'PT Amanah Jaya Mandiri', // sample
                'barang' => [
                    [
                        'id' => 1,
                        'jumlah_kotak' => 1,
                        'jumlah_dus' => 2,
                    ],
                    [
                        'id' => 2,
                        'jumlah_kotak' => 2,
                        'jumlah_dus' => 0,
                    ],
                ]
            ]
        );

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect();

        // test on database
        $expectedNomorPO = sprintf('001/WPM/PO.%s/%s', date('n'), date('Y'));
        $this->assertDatabaseHas('purchase_orders', [
            'nomor' => $expectedNomorPO,
            'tanggal' => date('Y-m-d'),
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('purchase_order_details', [
            'nomor_po' => $expectedNomorPO,
            'barang_id' => 1,
            'jumlah_kotak' => 1,
            'jumlah_dus' => 2,
        ]);

        $this->assertDatabaseHas('purchase_order_details', [
            'nomor_po' => $expectedNomorPO,
            'barang_id' => 2,
            'jumlah_kotak' => 2,
            'jumlah_dus' => 0,
        ]);

        $this->assertDatabaseHas('pengajuan_pembelian', [
            'id' => $pengajuanPembelian->id,
            'status' => PengajuanPembelian::STATUS_APPROVED
        ]);
    }

    public function testPengajuanPODenganJumlahQuantityBarangBerubah()
    {
        $this->markTestSkipped('Fitur ini belum diperlukan');

        $this->asAdminPurchasing();

        Barang::factory(10)->create();
        $pengaju = User::factory()->create(['role_id' => Role::ID_ADMIN_STOCK]);
        $pengajuanPembelian = PengajuanPembelian::factory()->create([
            'created_by' => $pengaju->id
        ]);
        $pengajuanPembelian->details()->createMany([
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 1,
                'jumlah_kotak' => 1,
                'jumlah_dus' => 2,
            ])->toArray(),
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 2,
                'jumlah_kotak' => 2,
                'jumlah_dus' => 0,
            ])->toArray()
        ]);

        // test send data
        $response = $this->post(
            route('admin-purchasing.purchasing-orders.store', ['pengajuanPembelian' => $pengajuanPembelian->id]),
            [
                'supplier' => 'PT Amanah Jaya Mandiri', // sample
                'barang' => [
                    [
                        'id' => 1,
                        'jumlah_kotak' => 2,
                        'jumlah_dus' => 10,
                    ],
                    [
                        'id' => 2,
                        'jumlah_kotak' => 3,
                        'jumlah_dus' => 3,
                    ],
                ]
            ]
        );

        $response->assertOk();
        $response->assertSessionDoesntHaveErrors();

        // test on database
        $expectedNomorPO = sprintf('001/WPM/PO.%s/%s', date('n'), date('Y'));
        $this->assertDatabaseHas('purchase_orders', [
            'nomor' => $expectedNomorPO,
            'tanggal' => date('Y-m-d'),
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('purchase_order_details', [
            'nomor_po' => $expectedNomorPO,
            'barang_id' => 1,
            'jumlah_kotak' => 2,
            'jumlah_dus' => 10,
        ]);

        $this->assertDatabaseHas('purchase_order_details', [
            'nomor_po' => $expectedNomorPO,
            'barang_id' => 2,
            'jumlah_kotak' => 3,
            'jumlah_dus' => 3,
        ]);

        $this->assertDatabaseHas('pengajuan_pembelian', [
            'id' => $pengajuanPembelian->id,
            'status' => PengajuanPembelian::STATUS_REVISED
        ]);
    }

    public function testPengajuanPODenganJumlahQuantityAdalahNol()
    {
        $this->asAdminPurchasing();

        Barang::factory(10)->create();
        $pengaju = User::factory()->create(['role_id' => Role::ID_ADMIN_STOCK]);
        $pengajuanPembelian = PengajuanPembelian::factory()->create([
            'created_by' => $pengaju->id
        ]);
        $pengajuanPembelian->details()->createMany([
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 1,
                'jumlah_kotak' => 1,
                'jumlah_dus' => 2,
            ])->toArray(),
            PengajuanPembelianDetail::factory()->make([
                'barang_id' => 2,
                'jumlah_kotak' => 2,
                'jumlah_dus' => 0,
            ])->toArray()
        ]);

        // test send data
        $response = $this->post(
            route('admin-purchasing.purchasing-orders.store', ['pengajuanPembelian' => $pengajuanPembelian->id]),
            [
                'supplier' => 'PT Amanah Jaya Mandiri', // sample
                'barang' => [
                    [
                        'id' => 1,
                        'jumlah_kotak' => 0,
                        'jumlah_dus' => 0,
                    ],
                    [
                        'id' => 2,
                        'jumlah_kotak' => 3,
                        'jumlah_dus' => 3,
                    ],
                ]
            ]
        );

        $response->assertOk();
        $response->assertSessionDoesntHaveErrors();

        // test on database
        $this->assertDatabaseEmpty('purchase_orders');
        $this->assertDatabaseEmpty('purchase_order_details');

    }
}

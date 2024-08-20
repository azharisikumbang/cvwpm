<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\PengajuanPembelian;
use App\Models\RiwayatStok;
use App\Models\RiwayatStokBibit;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PengajuanPembelianTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_stok_dapat_melihat_riwayat_pengajuan_pembelian()
    {
        $this->markTestIncomplete("Test lebih lanjut test bahwa barang yang ditampilkan hanya barang yang ada di gudang mereka");

        $adminStok = $this->asAdminStock();

        $this->actingAs($adminStok)
            ->get('/pengajuan-pembelian')
            ->assertStatus(200);
    }

    public function test_admin_purchasing_dapat_melihat_pengajuan_pembelian_yang_dibuat()
    {
        $this->markTestIncomplete("Test lebih lanjut test bahwa barang yang ditampilkan hanya barang yang ada di gudang mereka");

        $adminPurchasing = $this->asAdminPurchasing();

        $this->actingAs($adminPurchasing)
            ->get('/pengajuan-pembelian')
            ->assertStatus(200);
    }

    public function test_admin_stok_dapat_menambahkan_pengajuan_pembelian_dan_berkas_pengajuan()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        Barang::factory(10)->create([
            'gudang_id' => 1,
        ]);

        $adminStok = User::where('role_id', Role::ID_ADMIN_STOCK)->first();
        $this->actingAs($adminStok);

        $request = [
            'type' => 'BIBIT',
            'barang' => [
                [
                    'id' => 1,
                    'kotak' => 10,
                    'dus' => 5,
                    'satuan' => 0,
                ],
                [
                    'id' => 2,
                    'kotak' => 100,
                    'dus' => 10,
                    'satuan' => 3,
                ],
            ],
        ];

        $response = $this->actingAs($adminStok)->post('/pengajuan-pembelian', $request);

        $this->assertDatabaseHas('pengajuan_pembelian', [
            // 'nomor_pengajuan' => ,
            'tanggal_pengajuan' => now()->format('Y-m-d H:i:s'),
            'staf_pengaju_id' => 1,
            'status_pengajuan' => 'DRAFT',
        ]);

        // barang 1
        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 1,
            'riwayatable_id' => 1,
            'riwayatable_type' => PengajuanPembelian::class,
            'stokable_id' => 1,
            'stokable_type' => RiwayatStokBibit::class
        ]);

        $this->assertDatabaseHas('riwayat_stok_bibit', [
            'id' => 1,
            'kotak' => 10,
            'dus' => 5,
            'satuan' => 0,
        ]);

        // barang 2
        $this->assertDatabaseHas('riwayat_stok', [
            'barang_id' => 2,
            'riwayatable_id' => 1,
            'riwayatable_type' => PengajuanPembelian::class,
            'stokable_id' => 2,
            'stokable_type' => RiwayatStokBibit::class
        ]);

        $this->assertDatabaseHas('riwayat_stok_bibit', [
            'id' => 2,
            'kotak' => 100,
            'dus' => 10,
            'satuan' => 3,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Pengajuan pembelian berhasil ditambahkan');
    }

    public function test_pengajuan_pembelian_hanya_oleh_admin_stok()
    {
        $this->seed();
        Barang::factory(10)->create([
            'gudang_id' => 1,
        ]);

        $request = [
            'type' => 'BIBIT',
            'barang' => [
                [
                    'id' => 1,
                    'kotak' => 10,
                    'dus' => 5,
                    'satuan' => 0,
                ],
                [
                    'id' => 2,
                    'kotak' => 100,
                    'dus' => 10,
                    'satuan' => 3,
                ],
            ],
        ];

        // guest
        $this->asGuest();

        $this
            ->post('/pengajuan-pembelian', $request)
            ->assertStatus(302);
        ;

        // admin purchasing
        $this->asAdminPurchasing();
        $this
            ->post('/pengajuan-pembelian', $request)
            ->assertStatus(403);
        ;

        // manajer
        $this->asManager();
        $this
            ->post('/pengajuan-pembelian', $request)
            ->assertStatus(403);
        ;

        // sales
        $this->asSales();
        $this
            ->post('/pengajuan-pembelian', $request)
            ->assertStatus(403);
        ;
    }

    public function test_admin_purchasing_dapat_menyetujui_pengajuan_pembelian()
    {
        $this->withoutExceptionHandling();

        $this->seed();
        Barang::factory(10)->create([
            'gudang_id' => 1,
        ]);


        $adminPurchasing = User::where('role_id', Role::ID_ADMIN_PURCHASING)->first();
        $adminStok = User::where('role_id', Role::ID_ADMIN_STOCK)->first();

        $this->assertEquals($adminStok->staf->gudang_kerja, $adminPurchasing->staf->gudang_kerja);

        $pengajuan = PengajuanPembelian::factory()->create([
            'staf_pengaju_id' => $adminStok->staf->id,
        ]);

        $this->actingAs($adminPurchasing)
            ->put("/pengajuan-pembelian/" . $pengajuan->id . '/approve')
            ->assertStatus(302);

        $this->assertDatabaseHas('pengajuan_pembelian', [
            'id' => $pengajuan->id,
            'status_pengajuan' => 'DITERIMA',
        ]);
    }
}

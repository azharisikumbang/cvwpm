<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\PengajuanPembelian;
use App\Models\PurchaseOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PengajuanPembelianBarangTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminStokDapatMelihatHalamanPengajuanPembelian()
    {
        $this
            ->actingAs($this->asAdminStock())
            ->get(route('admin-stock.pengajuan-pembelian.index'))
            ->assertOk()
        ;

        $this
            ->actingAs($this->asAdminStock())
            ->get(route('admin-stock.pengajuan-pembelian.index'))
            ->assertViewIs('admin-stock.pengajuan-pembelian.index');
    }

    public function testPublikTidakDapatMengaksesHalamanPengajuanPembelian()
    {
        $this->get(route('admin-stock.pengajuan-pembelian.index'))
            ->assertRedirect('/login')
        ;

    }

    public function testBukanAdminStokTidakDapatMelihatHalamanPengajuanPembelian()
    {

        $this
            ->actingAs($this->asAdminWeb())
            ->get(route('admin-stock.pengajuan-pembelian.index'))
            ->assertForbidden()
        ;

        $this
            ->actingAs($this->asAdminPurchasing())
            ->get(route('admin-stock.pengajuan-pembelian.index'))
            ->assertForbidden()
        ;



        $this
            ->actingAs($this->asSales())
            ->get(route('admin-stock.pengajuan-pembelian.index'))
            ->assertForbidden()
        ;


    }

    public function testAdminStokDapatMelihatFormPengajuanPembelian()
    {
        $this
            ->actingAs($this->asAdminStock())
            ->get(route('admin-stock.pengajuan-pembelian.create'))
            ->assertOk();
    }

    public function testAdminStokDapatMengajukanPembelian()
    {
        $barang = Barang::factory(10)->create();

        $this
            ->actingAs($this->asAdminStock())
            ->post(route('admin-stock.pengajuan-pembelian.store'), [
                'catatan' => 'Pembelian barang untuk kebutuhan produksi',
                'barang' => [
                    [
                        'barang_id' => 1,
                        'jumlah_kotak' => 3,
                        'jumlah_dus' => 10,
                    ],
                    [
                        'barang_id' => 2,
                        'jumlah_kotak' => 5,
                        'jumlah_dus' => 20,
                    ]
                ]
            ])
            ->assertRedirect()
        ;

        $this->assertDatabaseCount('pengajuan_pembelian', 1);
        $this->assertDatabaseCount('pengajuan_pembelian_details', 2);

        $this->assertDatabaseHas('pengajuan_pembelian', [
            'created_at' => now(),
            'status' => 'pending',
            'catatan' => 'Pembelian barang untuk kebutuhan produksi',
            'created_by' => 1,
        ]);

        $this->assertDatabaseHas('pengajuan_pembelian_details', [
            'pengajuan_pembelian_id' => 1,
            'barang_id' => 1,
            'jumlah_kotak' => 3,
            'jumlah_dus' => 10,
        ]);

        $this->assertDatabaseHas('pengajuan_pembelian_details', [
            'pengajuan_pembelian_id' => 1,
            'barang_id' => 2,
            'jumlah_kotak' => 5,
            'jumlah_dus' => 20,
        ]);
    }

    public function testAdminStokMengajukanPembelianDenganBarangYangTidakAda()
    {
        $this
            ->actingAs($this->asAdminStock())
            ->post(route('admin-stock.pengajuan-pembelian.store'), [
                'catatan' => 'Pembelian barang untuk kebutuhan produksi',
                'barang' => [
                    [
                        'barang_id' => 1,
                        'jumlah_kotak' => 3,
                        'jumlah_dus' => 10,
                    ],
                    [
                        'barang_id' => 2,
                        'jumlah_kotak' => 5,
                        'jumlah_dus' => 20,
                    ]
                ]
            ])
            ->assertSessionHasErrors('barang.0.barang_id')
            ->assertSessionHasErrors('barang.1.barang_id')
            ->assertRedirect()
        ;

        $this->assertDatabaseCount('pengajuan_pembelian', 0);
        $this->assertDatabaseCount('pengajuan_pembelian_details', 0);
    }

    public function testAdminStokMegajukanPermintaanPembelianDenganJumlahBarangNol()
    {
        $this->markTestIncomplete('belum ada penjelasan lebih lanjut tentang jumlah barang nol');
        $barang = Barang::factory(2)->create();

        $this
            ->actingAs($this->asAdminStock())
            ->post(route('admin-stock.pengajuan-pembelian.store'), [
                'catatan' => 'Pembelian barang untuk kebutuhan produksi',
                'barang' => [
                    [
                        'barang_id' => 1,
                        'jumlah_kotak' => 0,
                        'jumlah_dus' => 0,
                    ],
                    [
                        'barang_id' => 2,
                        'jumlah_kotak' => 0,
                        'jumlah_dus' => 0,
                    ]
                ]
            ])
            ->assertSessionHasErrors('barang.0.jumlah_kotak')
            ->assertSessionHasErrors('barang.0.jumlah_dus')
            ->assertSessionHasErrors('barang.1.jumlah_kotak')
            ->assertSessionHasErrors('barang.1.jumlah_dus')
            ->assertRedirect()
        ;

        $this->assertDatabaseCount('pengajuan_pembelian', 0);
        $this->assertDatabaseCount('pengajuan_pembelian_details', 0);
    }

    public function testAdminStokDapatMelihatDetailPengajuanPembelian()
    {
        $this->markTestIncomplete();

        $pengajuanPembelian = PengajuanPembelian::factory()->create();

        $this
            ->actingAs($this->asAdminStock())
            ->get(route('admin-stock.pengajuan-pembelian.show', $pengajuanPembelian))
            ->assertOk()
        ;

        $this
            ->actingAs($this->asAdminStock())
            ->get(route('admin-stock.pengajuan-pembelian.show', $pengajuanPembelian))
            ->assertViewIs('admin-stock.pengajuan-pembelian.show')
        ;
    }

}

<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Staf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ManajemenBarangTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_manajemen_barang_tidak_dapat_diakses_oleh_publik()
    {
        $this->markTestIncomplete();

        $this->asGuest();
        Barang::factory(10)->create();

        $response = $this->get('/admin-stock/barang');
        $response->assertRedirect('/login');

        $response = $this->get('/admin-stock/barang/create');
        $response->assertRedirect('/login');

        $response = $this->get('/admin-stock/barang/1/edit');
        $response->assertRedirect('/login');

        $response = $this->post('/admin-stock/barang', [
            'nama' => 'Barang Baru',
            'harga' => 10000,
            'satuan' => 'pcs'
        ]);
        $response->assertRedirect('/login');

        $response = $this->put('/admin-stock/barang/1', [
            'nama' => 'Barang Baru',
            'harga' => 10000,
            'satuan' => 'pcs'
        ]);
        $response->assertRedirect('/login');

        $response = $this->delete('/admin-stock/barang/1');
        $response->assertRedirect('/login');
    }

    public function test_halaman_manajemen_barang_tidak_dapat_diakses_oleh_hak_akses_bukan_admin_stok()
    {
        $this->markTestIncomplete();

        $this->asAdminWeb();
        Barang::factory(10)->create();

        $response = $this->get('/admin-stock/barang');
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->get('/admin-stock/barang/create');
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->get('/admin-stock/barang/1/edit');
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->post('/admin-stock/barang', [
            'nama' => 'Barang Baru',
            'harga' => 10000,
            'satuan' => 'pcs'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->put('/admin-stock/barang/1', [
            'nama' => 'Barang Baru',
            'harga' => 10000,
            'satuan' => 'pcs'
        ]);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $response = $this->delete('/admin-stock/barang/1');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    // see page
    public function test_halaman_barang()
    {
        $this->markTestIncomplete();

        $this->asAdminStock();

        $response = $this->get('/admin-stock/barang');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_halaman_tambah_barang()
    {
        $this->markTestIncomplete();

        $this->asAdminStock();

        $response = $this->get('/admin-stock/barang/create');
        $response->assertStatus(200);
    }

    public function test_halaman_barang_edit()
    {
        $this->markTestIncomplete();

        Barang::factory(10)->create();

        $this->asAdminStock();

        $response = $this->get('/admin-stock/barang/1/edit');
        $response->assertStatus(200);
    }

    // fitur
    public function testTambahDataBarangBaru()
    {
        $user = $this->asAdminStock();
        [$gudang, $staf] = $this->setUpGudangAndStaf($user);

        $request = [
            'nama' => 'Barang Baru',
            'kemasan' => [
                ['varian' => '10gr', 'harga' => 10000, 'satuan_per_dus' => 100, 'satuan_per_kotak' => 10],
                ['varian' => '20gr', 'harga' => 20000, 'satuan_per_dus' => 90, 'satuan_per_kotak' => 9],
                ['varian' => '30gr', 'harga' => 30000, 'satuan_per_dus' => 80, 'satuan_per_kotak' => 8]
            ],
            'satuan' => 'pcs'
        ];

        $response = $this->post('/admin-stock/barang', $request);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/admin-stock/barang');

        $this->assertDatabaseHas('barang', [
            'gudang_id' => $gudang->id,
            'kode_barang' => 'PDG-BBT-001',
            'nama' => 'Barang Baru',
            'harga' => 10000,
            'kemasan' => '10gr',
            'satuan' => 'pcs',
            'satuan_per_dus' => 100,
            'satuan_per_kotak' => 10,
            'jumlah_dus' => 0,
            'jumlah_satuan' => 0,
            'jumlah_kotak' => 0,
        ]);

        $this->assertDatabaseHas('barang', [
            'gudang_id' => $gudang->id,
            'kode_barang' => 'PDG-BBT-002',
            'nama' => 'Barang Baru',
            'harga' => 20000,
            'kemasan' => '20gr',
            'satuan' => 'pcs',
            'satuan_per_dus' => 90,
            'satuan_per_kotak' => 9,
            'jumlah_dus' => 0,
            'jumlah_satuan' => 0,
            'jumlah_kotak' => 0,
        ]);

        $this->assertDatabaseHas('barang', [
            'gudang_id' => $gudang->id,
            'kode_barang' => 'PDG-BBT-003',
            'nama' => 'Barang Baru',
            'harga' => 30000,
            'kemasan' => '30gr',
            'satuan' => 'pcs',
            'satuan_per_dus' => 80,
            'satuan_per_kotak' => 8,
            'jumlah_dus' => 0,
            'jumlah_satuan' => 0,
            'jumlah_kotak' => 0,
        ]);
    }

    public function test_ubah_data_barang()
    {
        $this->markTestIncomplete();

        $this->asAdminStock();
        $barang = Barang::factory()->create();

        $response = $this->put('/admin-stock/barang/' . $barang->id, [
            'nama' => 'Barang Baru',
            'harga' => 10000,
            'satuan' => 'pcs'
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/admin-stock/barang');

        $this->assertDatabaseHas('barang', [
            'nama' => 'Barang Baru',
            'harga' => 10000,
            'satuan' => 'pcs'
        ]);
        $this->assertDatabaseCount('barang', 1);
    }

    public function test_hapus_data_barang()
    {
        $this->markTestIncomplete();

        $this->asAdminStock();
        $barang = Barang::factory()->create();

        $response = $this->delete('/admin-stock/barang/' . $barang->id);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/admin-stock/barang');

        $this->assertDatabaseMissing('barang', [
            'nama' => $barang->nama,
            'harga' => $barang->harga,
            'satuan' => $barang->satuan
        ]);
        $this->assertDatabaseCount('barang', 0);
    }

    public function test_tambah_data_dengan_data_kosong()
    {
        $this->markTestIncomplete();

        $this->asAdminStock();

        $response = $this->post('/admin-stock/barang', [
            'nama' => '',
            'harga' => '',
            'satuan' => ''
        ]);

        $response->assertSessionHasErrors(['nama', 'harga', 'satuan']);
    }

    public function test_tambah_barang_dengan_harga_dibawah_nol()
    {
        $this->markTestIncomplete();
        $this->asAdminStock();

        $response = $this->post('/admin-stock/barang', [
            'nama' => 'Barang Baru',
            'harga' => -1,
            'satuan' => 'pcs'
        ]);

        $response->assertSessionHasErrors(['harga']);
        $this->assertDatabaseCount('barang', 0);
    }

    public function test_edit_barang_dengan_harga_dibawah_nol()
    {
        $this->markTestIncomplete();
        $this->asAdminStock();
        $barang = Barang::factory()->create(['harga' => 10000]);

        $response = $this->put("/admin-stock/barang/" . $barang->id, [
            'nama' => 'Barang Baru',
            'harga' => -1,
            'satuan' => 'pcs'
        ]);

        $response->assertSessionHasErrors(['harga']);
        $this->assertDatabaseHas('barang', [
            'nama' => $barang->nama,
            'harga' => (int) $barang->harga,
            'satuan' => $barang->satuan
        ]);
        $this->assertDatabaseCount('barang', 1);
    }

    public function test_tambah_dengan_nama_barang_yang_sudah_terdata()
    {
        $this->markTestIncomplete();
        $this->asAdminStock();
        $barang = Barang::factory()->create();

        $response = $this->post('/admin-stock/barang', [
            'nama' => $barang->nama,
            'harga' => 10000,
            'satuan' => 'pcs'
        ]);

        $response->assertSessionHasErrors(['nama']);
        $this->assertDatabaseCount('barang', 1);
    }
}

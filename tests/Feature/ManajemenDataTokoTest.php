<?php

namespace Tests\Feature;

use App\Models\Toko;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManajemenDataTokoTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = "/admin-stock/toko";

    public function test_halaman_tidak_dapat_diakses_oleh_publik()
    {
        $this->asGuest();

        $this->get(self::ROUTE)
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_halaman_tidak_dapat_diakses_oleh_bukan_admin_stok()
    {
        Toko::factory(10)->create();

        $this->asAdminWeb();

        $this->get(self::ROUTE)
            ->assertStatus(403);

        $this->get(self::ROUTE . '/create')
            ->assertStatus(403);

        $this->get(self::ROUTE . '/1/edit')
            ->assertStatus(403);

        $this->delete(self::ROUTE . '/1')
            ->assertStatus(403);

        $this->post(self::ROUTE)
            ->assertStatus(403);

        $this->delete(self::ROUTE . '/1')
            ->assertStatus(403);
    }

    public function test_halaman_dapat_diakses_oleh_admin_stok()
    {
        Toko::factory(10)->create();
        $this->asAdminStock();

        $this->get(self::ROUTE)->assertOk();
        $this->get(self::ROUTE . '/create')->assertOk();
        $this->get(self::ROUTE . '/1/edit')->assertOk();
    }

    public function test_data_toko_dapat_disimpan()
    {
        $this->asAdminStock();

        $data = Toko::factory()->make()->toArray();

        $this->post(self::ROUTE, $data)
            ->assertStatus(302)
            ->assertSessionHas('success', 'Data toko berhasil disimpan.');

        $this->assertDatabaseHas('toko', $data);
    }

    public function test_simpan_data_toko_dengan_hanya_nama_dan_alamat()
    {
        $this->asAdminStock();

        $data = Toko::factory()->make([
            'cp' => null,
            'up' => null,
        ])->toArray();

        $this->post(self::ROUTE, $data)
            ->assertStatus(302)
            ->assertSessionHas('success', 'Data toko berhasil disimpan.');

        $this->assertDatabaseHas('toko', $data);
    }

    public function test_simpan_data_dengan_nama_dan_alamat_kosong_harus_gagal()
    {
        $this->asAdminStock();

        $data = Toko::factory()->make([
            'nama' => '',
            'alamat' => '',
        ])->toArray();

        $this->post(self::ROUTE, $data)
            ->assertStatus(302)
            ->assertSessionHasErrors(['nama', 'alamat']);

        $this->assertDatabaseMissing('toko', $data);
    }

    public function test_data_toko_dapat_diperbarui()
    {
        $this->asAdminStock();

        $toko = Toko::factory()->create();
        $data = Toko::factory()->make()->toArray();

        $this->put(self::ROUTE . "/{$toko->id}", $data)
            ->assertStatus(302)
            ->assertSessionHas('success', 'Data toko berhasil diperbarui.');

        $this->assertDatabaseHas('toko', $data);
    }

    public function test_perbarui_data_toko_dengan_nama_dan_alamat_kosong_harus_gagal()
    {
        $this->asAdminStock();

        $toko = Toko::factory()->create();
        $data = Toko::factory()->make([
            'nama' => '',
            'alamat' => '',
        ])->toArray();

        $this->put(self::ROUTE . "/{$toko->id}", $data)
            ->assertStatus(302)
            ->assertSessionHasErrors(['nama', 'alamat']);

        $this->assertDatabaseMissing('toko', $data);
    }

    public function test_data_toko_dapat_dihapus()
    {
        $this->asAdminStock();

        $toko = Toko::factory()->create();

        $this->delete(self::ROUTE . "/{$toko->id}")
            ->assertStatus(302)
            ->assertSessionHas('success', 'Data toko berhasil dihapus.');

        $this->assertDatabaseMissing('toko', $toko->toArray());
    }
}

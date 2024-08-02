<?php

namespace Tests\Feature;

use App\Models\Barang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PerubahanHargaBarangTest extends TestCase
{
    use RefreshDatabase;

    public function testPerubahanHargaBarangOlehAdminStok()
    {
        $user = $this->asAdminStock();
        [$gudang, $staf] = $this->setUpGudangAndStaf($user);

        Barang::factory(10)->create([
            'gudang_id' => $gudang->id
        ]);

        $barang = Barang::first();

        $response = $this->put(route('admin-stock.barang.harga.update', $barang), [
            'harga' => 10000
        ]);

        $response->assertRedirect(route('admin-stock.barang.index'));
        $response->assertSessionHas('success', "Harga barang '{$barang->nama_kemasan}' berhasil diubah.");

        $this->assertDatabaseHas('barang', [
            'id' => $barang->id,
            'harga' => 10000
        ]);

        $this->assertDatabaseCount('barang', 10);
    }

    public function testPerubahanHargaBarangDiBawahNol()
    {
        $user = $this->asAdminStock();
        [$gudang, $staf] = $this->setUpGudangAndStaf($user);

        Barang::factory(10)->create([
            'gudang_id' => $gudang->id
        ]);

        $expectedHarga = 5000;
        $barang = Barang::factory()->create([
            'gudang_id' => $gudang->id,
            'harga' => $expectedHarga
        ]);

        $response = $this->put(route('admin-stock.barang.harga.update', $barang), [
            'harga' => -1
        ]);

        $response->assertSessionHasErrors('harga');

        $this->assertDatabaseHas('barang', [
            'id' => $barang->id,
            'harga' => $barang->harga
        ]);

        $this->assertDatabaseCount('barang', 11);
    }
}

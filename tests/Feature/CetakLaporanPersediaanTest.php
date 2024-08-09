<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Gudang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CetakLaporanPersediaanTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_access_laporan_persediaan_page()
    {
        $this->asManager();

        $this
            ->createGudang(10)
            ->map(function ($gudang) {
                Barang::factory(10)->create([
                    'gudang_id' => $gudang->id
                ]);
            });

        $response = $this->get(route('laporan-persediaan.create'));
    }

    public function test_see_data_laporan_persediaan()
    {
        $this->asManager();

        $this
            ->createGudang(10)
            ->map(function ($gudang) {
                Barang::factory(10)->create([
                    'gudang_id' => $gudang->id
                ]);
            });

        $requestGudang = Gudang::first();
        $requestYear = date('Y');
        $requestMonth = date('m');
        $request = [
            'gudang' => $requestGudang->id,
            'year' => $requestYear,
            'month' => $requestMonth,
        ];

        $response = $this->post(route('laporan-persediaan.store'), $request);

        $response->assertOk();
    }
}

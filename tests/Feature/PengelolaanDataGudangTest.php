<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PengelolaanDataGudangTest extends TestCase
{
    use RefreshDatabase;

    public function testTambahDataGudang()
    {
        $this->asAdminWeb();

        $request = [
            'kode_gudang' => 'PDG',
            'nama' => 'Gudang Padang',
            'lokasi' => 'Padang',
            'penanggung_jawab' => null
        ];

        // send request
        $response = $this->post('/admin-web/gudang', $request);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('gudang', [
            'kode_gudang' => $request['kode_gudang'],
            'nama' => $request['nama'],
            'lokasi' => $request['lokasi'],
            'penanggung_jawab' => $request['penanggung_jawab']
        ]);
    }
}

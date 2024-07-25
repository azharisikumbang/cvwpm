<?php

namespace Tests\Feature;

use App\Models\Gudang;
use App\Models\Role;
use App\Models\Staf;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PengelolaanStafTest extends TestCase
{
    use RefreshDatabase;

    public function testTambahStafKeGudang()
    {
        $this->asAdminWeb();

        // supply data
        $penanggungJawabUser = User::factory()->create([
            'role_id' => Role::ID_ADMIN_STOCK
        ]);

        $penanggungJawabStaf = Staf::factory()->create([
            'jabatan' => Role::ID_ADMIN_STOCK,
            'user_id' => $penanggungJawabUser->id
        ]);


        $gudang = Gudang::create([
            'nama' => 'Gudang Padang',
            'lokasi' => 'Padang',
            'penanggung_jawab' => $penanggungJawabStaf->id
        ]);

        $request = [
            'nama' => 'Abdul',
            'jabatan' => Role::ID_SALES,
            'kontak' => '081234567890',
            'gudang_kerja' => $gudang->id
        ];

        // send request
        $response = $this->post('/admin-web/staf', $request);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('staf', [
            'nama' => $request['nama'],
            'jabatan' => $request['jabatan'],
            'kontak' => $request['kontak'],
            'gudang_kerja' => $request['gudang_kerja']
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Gudang;
use App\Models\Role;
use App\Models\Staf;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TambahkanAkunUserKeStafTest extends TestCase
{
    use RefreshDatabase;

    public function testTambahAkunKeStaf()
    {
        $this->markTestIncomplete();
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

        $newStaf = Staf::factory()->create([
            'gudang_kerja' => $gudang->id,
            'jabatan' => 'Admin Stock'
        ]);

        $request = [
            'username' => 'abdul',
            'password' => 'password',
            'password_confirmation' => 'password',
            'staf' => $newStaf->id,
        ];

        // send request
        $response = $this->post('/admin-web/users', $request);

        $response->assertStatus(302);
        $response->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('users', [
            'username' => $request['username'],
            'role_id' => Role::ID_ADMIN_STOCK,
        ]);

        $this->assertDatabaseHas('staf', [
            'id' => $newStaf->id,
            'user_id' => User::where('username', $request['username'])->first()->id,
        ]);

    }
}

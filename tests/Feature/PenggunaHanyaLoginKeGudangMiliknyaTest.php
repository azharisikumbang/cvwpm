<?php

namespace Tests\Feature;

use App\Models\Gudang;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PenggunaHanyaLoginKeGudangMiliknyaTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginAdminStokDenganGudangPadang()
    {
        $this->markTestIncomplete();

        User::factory(10)->create();

        $adminStok = User::factory()->create([
            'username' => 'adminstok',
            'password' => bcrypt('adminstok'),
            'role_id' => Role::ID_ADMIN_STOCK
        ]);

        $gudang = Gudang::factory()->create([
            'nama' => 'Padang',
            'penanggung_jawab' => $adminStok->id
        ]);

        $response = $this
            ->actingAs($adminStok)
            ->post('login', [
                'username' => $adminStok->username,
                'password' => 'adminstok'
            ]);

        $response->assertRedirect('/admin-stock');
    }

}

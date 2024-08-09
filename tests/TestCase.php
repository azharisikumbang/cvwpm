<?php

namespace Tests;

use App\Models\Gudang;
use App\Models\Role;
use App\Models\Staf;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function asAdminWeb()
    {
        $user = User::factory()->create([
            'role_id' => Role::ID_ADMIN_WEB
        ]);

        $this->actingAs($user);

        return $user;
    }
    public function asAdminStock()
    {
        $user = User::factory()->create([
            'role_id' => Role::ID_ADMIN_STOCK
        ]);

        $this->actingAs($user);

        return $user;
    }
    public function asAdminPurchasing()
    {
        $user = User::factory()->create([
            'role_id' => Role::ID_ADMIN_PURCHASING
        ]);

        $this->actingAs($user);

        return $user;
    }
    public function asSales()
    {
        $user = User::factory()->create([
            'role_id' => Role::ID_SALES
        ]);

        $this->actingAs($user);

        return $user;
    }

    public function asManager()
    {
        $user = User::factory()->create([
            'role_id' => Role::ID_MANAGER
        ]);

        $this->actingAs($user);

        return $user;
    }
    public function asGuest()
    {
        $this->assertGuest();
    }
    public function setUpGudangAndStaf(User $user)
    {
        $gudang = Gudang::factory()->create([
            'kode_gudang' => 'PDG',
            'lokasi' => 'Padang',
            'nama' => 'Gudang Padang'
        ]);

        $staf = Staf::factory()->create([
            'jabatan' => 'Admin Stock',
            'user_id' => $user->id,
            'gudang_kerja' => $gudang->id
        ]);

        return [$gudang, $staf];
    }

    public function createGudang(int $total = 10)
    {
        return Gudang::factory($total)->create();
    }
}

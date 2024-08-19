<?php

namespace Tests\Traits;

use App\Models\Role;
use App\Models\User;

trait UserTrait
{
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
}
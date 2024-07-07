<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_user_cannot_see_non_guest_page()
    {
        $response = $this->get('/admin-web');
        $response->assertRedirect('/login');

        $response = $this->get('/admin-stock');
        $response->assertRedirect('/login');

        $response = $this->get('/admin-purchasing');
        $response->assertRedirect('/login');

        $response = $this->get('/sales');
        $response->assertRedirect('/login');

        $response = $this->get('/manager');
        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_authorized_role_can_access_related_page()
    {
        $user = User::factory()->create(['role_id' => Role::ID_ADMIN_WEB]);
        $this->actingAs($user);

        $response = $this->get('/admin-web');

        $response->assertStatus(200);
    }

    public function test_unauthorized_role_can_access_related_page()
    {
        $user = User::factory()->create(['role_id' => Role::ID_ADMIN_WEB]);
        $this->actingAs($user);

        $response = $this->get('/admin-stock');
        $response->assertStatus(403);

        $response = $this->get('/admin-purchasing');
        $response->assertStatus(403);

        $response = $this->get('/sales');
        $response->assertStatus(403);

        $response = $this->get('/manager');
        $response->assertStatus(403);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_see_user_management_page()
    {
        //authenticated bu but WEB_ADMIN
        $nonAdminUser = User::factory()->create(['role_id' => Role::ID_ADMIN_STOCK]);

        $response = $this->actingAs($nonAdminUser)->get(route('admin-web.users.index'));

        $response->assertStatus(403);
        $this->assertAuthenticatedAs($nonAdminUser);

        // unauthenticated
        $response = $this->get(route('admin-web.users.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_see_valid_user_add_form()
    {
        $admin = User::factory()->create(['role_id' => Role::ID_ADMIN_WEB]);

        $response = $this->actingAs($admin)->get(route('admin-web.users.create'));

        $response->assertStatus(200);
    }

    public function test_user_can_be_created()
    {
        $admin = User::factory()->create(['role_id' => Role::ID_ADMIN_WEB]);

        $request = [
            'name' => 'Test User',
            'email' => 'test@localhost',
            'role_id' => Role::ID_ADMIN_STOCK,
            'password' => 'password',
            'username' => 'testuser'
        ];

        $response = $this->actingAs($admin)->post(route('admin-web.users.store'), $request);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin-web.users.index'));
        $response->assertSessionHas('success', 'Pengguna baru berhasil ditambahkan.');

        $this->assertDatabaseHas('users', [
            'name' => $request['name'],
            'email' => $request['email'],
            'role_id' => $request['role_id'],
            'username' => $request['username']
        ]);

        $this->assertDatabaseCount('users', 2);
    }

    public function test_invalid_input_cannot_create_new_user()
    {
        $admin = User::factory()->create(['role_id' => Role::ID_ADMIN_WEB]);

        $request = [
            'name' => '',
            'email' => '',
            'role_id' => 0,
            'password' => '',
            'username' => ''
        ];

        $response = $this->actingAs($admin)->post(route('admin-web.users.store'), $request);

        $response->assertSessionHasErrors(['name', 'email', 'role_id', 'password', 'username']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_cannot_add_duplicate_username()
    {
        $admin = User::factory()->create(['role_id' => Role::ID_ADMIN_WEB]);

        $request = [
            'name' => 'test',
            'email' => 'test@gmal.com',
            'role_id' => Role::ID_ADMIN_WEB,
            'password' => 'testpassword',
            'username' => $admin->username
        ];

        $response = $this->actingAs($admin)->post(route('admin-web.users.store'), $request);

        $response->assertSessionHasErrors(['username']);
        $this->assertDatabaseCount('users', 1);
    }
}

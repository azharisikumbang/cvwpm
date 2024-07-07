<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_authententicated_users_cannot_see_login_page_and_redirected_correctly()
    {
        $user = User::factory()->create(['role_id' => Role::ID_ADMIN_WEB]);

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/admin-web');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_has_username_and_password_input()
    {
        $response = $this->get('/login');

        $response->assertSee('username');
        $response->assertSee('password');
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'username' => 'usertest',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'username' => 'usertest',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors();

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_with_blank_input_should_redirect_back()
    {
        $response = $this->post('/login', [
            'username' => '',
            'password' => ''
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_authenticated_admin_web_redirect_to_correct_page()
    {
        // user with role admin
        $user = User::factory()->create([
            'username' => 'admin@test',
            'password' => bcrypt('password'),
            'role_id' => Role::ID_ADMIN_WEB # see App\Models\Role
        ]);

        $response = $this->post('/login', [
            'username' => 'admin@test',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin-web');
        $response->assertSessionDoesntHaveErrors();
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_admin_stock_redirect_to_correct_page()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role_id' => Role::ID_ADMIN_STOCK # see App\Models\Role
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin-stock');
        $response->assertSessionDoesntHaveErrors();
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_admin_purchasing_redirect_to_correct_page()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role_id' => Role::ID_ADMIN_PURCHASING # see App\Models\Role
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin-purchasing');
        $response->assertSessionDoesntHaveErrors();
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_sales_redirect_to_correct_page()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role_id' => Role::ID_SALES # see App\Models\Role
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect('/sales');
        $response->assertSessionDoesntHaveErrors();
        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_manager_redirect_to_correct_page()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
            'role_id' => Role::ID_MANAGER # see App\Models\Role
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect('/manager');
        $response->assertSessionDoesntHaveErrors();
        $this->assertAuthenticatedAs($user);
    }


    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();

    }
}

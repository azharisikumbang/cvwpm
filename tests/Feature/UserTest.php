<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_profile_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/user/profile');

        $response->assertStatus(200);
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/user/profile', [
            'name' => 'newname',
            'email' => 'newemail@localtest'
        ]);

        $response->assertRedirect('/user/profile');
        $response->assertSessionHas('success', 'Profil pengguna berhasil diperbaharui.');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'newname',
            'email' => 'newemail@localtest',
        ]);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_update_profile_doesnt_affect_other_user()
    {
        User::factory(10)->create();

        $testUser = User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@localtest',
        ]);

        $user = User::factory()->create([
            'username' => 'user',
        ]);

        $this->actingAs($user)->put('/user/profile', [
            'name' => 'newname',
            'email' => 'newemail@localtest'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'name' => 'Test User',
            'email' => 'test@localtest',
            'role_id' => $testUser->role->id,
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'newname',
            'email' => 'newemail@localtest',
            'role_id' => $testUser->role->id,
        ]);
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
        ]);

        $response = $this->actingAs($user)->put('/user/password', [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect('/user/password');
        $response->assertSessionHas('success', 'Password pengguna berhasil diperbaharui.');

        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
        ]);

        $this->assertTrue(Auth::attempt([
            'username' => $user->username,
            'password' => 'newpassword'
        ]));
    }

    public function test_update_password_dont_affect_other_users_password()
    {
        $user1 = User::factory()->create([
            'username' => 'user1',
            'password' => 'user1password'
        ]);

        $user2 = User::factory()->create([
            'username' => 'user2',
            'password' => 'user2password'
        ]);

        $this->actingAs($user1)->put('/user/password', [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $this->assertTrue(Auth::attempt([
            'username' => 'user2',
            'password' => 'user2password'
        ]));
    }
}

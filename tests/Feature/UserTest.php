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

    public function test_user_can_update_password()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
        ]);

        $response = $this->actingAs($user)->put('/user/password', [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect('/user/profile');
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

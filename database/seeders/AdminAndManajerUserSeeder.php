<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAndManajerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // user with no staf
        User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_WEB
        ]);

        User::factory()->create([
            'username' => 'manager',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_MANAGER
        ]);
    }
}

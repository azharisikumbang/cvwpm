<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // admin
        User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_WEB
        ]);

        User::factory()->create([
            'username' => 'adminstock',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_STOCK
        ]);
    }
}

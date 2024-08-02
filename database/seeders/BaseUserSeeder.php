<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Staf;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BaseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Staf Padang
        // staf admin stok
        $stock = User::factory()->create([
            'username' => 'stockpadang',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_STOCK
        ]);

        Staf::factory()->create([
            'nama' => 'Azhari',
            'kontak' => '081234567890',
            'jabatan' => Role::find(Role::ID_ADMIN_STOCK)->getDisplaybleName(),
            'gudang_kerja' => 1,
            'user_id' => $stock->id
        ]);

        // staff purchasing
        $purchasing = User::factory()->create([
            'username' => 'purchasingpadang',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_PURCHASING
        ]);

        Staf::factory()->create([
            'nama' => 'Zulham',
            'kontak' => '081234567890',
            'jabatan' => Role::find(Role::ID_ADMIN_PURCHASING)->getDisplaybleName(),
            'gudang_kerja' => 1,
            'user_id' => $purchasing->id
        ]);

        // staff sales
        $sales = User::factory()->create([
            'username' => 'salespadang',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_SALES
        ]);

        Staf::factory()->create([
            'nama' => 'Rizal',
            'kontak' => '081234567890',
            'jabatan' => Role::find(Role::ID_SALES)->getDisplaybleName(),
            'gudang_kerja' => 1,
            'user_id' => $sales->id
        ]);

        // solok 
        // staf admin stok
        $stock = User::factory()->create([
            'username' => 'stocksolok',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_STOCK
        ]);

        Staf::factory()->create([
            'nama' => 'Stok Solok',
            'kontak' => '081234567890',
            'jabatan' => Role::find(Role::ID_ADMIN_STOCK)->getDisplaybleName(),
            'gudang_kerja' => 2,
            'user_id' => $stock->id
        ]);

        // staff purchasing
        $purchasing = User::factory()->create([
            'username' => 'purchasingsolok',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_PURCHASING
        ]);

        Staf::factory()->create([
            'nama' => 'Purchasing Solok',
            'kontak' => '081234567890',
            'jabatan' => Role::find(Role::ID_ADMIN_PURCHASING)->getDisplaybleName(),
            'gudang_kerja' => 2,
            'user_id' => $purchasing->id
        ]);

        // staff sales
        $sales = User::factory()->create([
            'username' => 'salessolok',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_SALES
        ]);

        Staf::factory()->create([
            'nama' => 'Sales Solok',
            'kontak' => '081234567890',
            'jabatan' => Role::find(Role::ID_SALES)->getDisplaybleName(),
            'gudang_kerja' => 2,
            'user_id' => $sales->id
        ]);
    }
}

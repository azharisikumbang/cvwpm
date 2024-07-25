<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\PengajuanPembelian;
use App\Models\Role;
use App\Models\Staf;
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

        $this->call([GudangSeeder::class]);

        // staf admin stok
        $stock = User::factory()->create([
            'username' => 'stockpadang',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_STOCK
        ]);

        Staf::factory()->create([
            'nama' => 'Azhari',
            'kontak' => '081234567890',
            'jabatan' => "Admin Stok",
            'gudang_kerja' => 1,
            'user_id' => $stock->id
        ]);

        // admin purchasing
        $purchasing = User::factory()->create([
            'username' => 'purchasingpadang',
            'password' => Hash::make('12345678'),
            'role_id' => Role::ID_ADMIN_PURCHASING
        ]);

        Staf::factory()->create([
            'nama' => 'Zulham',
            'kontak' => '081234567890',
            'jabatan' => "Admin Purchasing",
            'gudang_kerja' => 1,
            'user_id' => $purchasing->id
        ]);

        // barang
        Barang::factory(100)->create([
            'gudang_id' => 1
        ]);
    }
}

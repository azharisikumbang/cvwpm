<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\PengajuanPembelian;
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

        $this->call([GudangSeeder::class]);

        // // admin stock
        // User::factory()->create([
        //     'username' => 'adminstock',
        //     'password' => Hash::make('12345678'),
        //     'role_id' => Role::ID_ADMIN_STOCK
        // ]);

        // // admin purchasing
        // User::factory()->create([
        //     'username' => 'adminpurchasing',
        //     'password' => Hash::make('12345678'),
        //     'role_id' => Role::ID_ADMIN_PURCHASING
        // ]);

        // // manajer
        // User::factory()->create([
        //     'username' => 'manajer',
        //     'password' => Hash::make('12348678'),
        //     'role_id' => Role::ID_MANAGER
        // ]);

        // $barang = Barang::factory(100)->create();

        // $pengajuanPembelian = PengajuanPembelian::factory(10)->create([
        //     'created_by' => User::where('role_id', Role::ID_ADMIN_STOCK)->first()->id
        // ]);

        // $pengajuanPembelian->each(function ($pengajuan) use ($barang) {
        //     $pengajuan->details()->createMany(
        //         $barang->random(rand(1, 10))->map(function ($barang) {
        //             return [
        //                 'barang_id' => $barang->id,
        //                 'jumlah_dus' => rand(1, 10),
        //                 'jumlah_kotak' => rand(1, 10),
        //             ];
        //         })->toArray()
        //     );
        // });

        // $this->call([]);
    }
}

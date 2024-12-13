<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Produk::factory(9)->create();

        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => 'password',
            'is_admin' => true,
        ]);
        User::create([
            'nama' => 'Kasir',
            'username' => 'kasir',
            'password' => 'password',
            'is_admin' => false,
        ]);
    }
}

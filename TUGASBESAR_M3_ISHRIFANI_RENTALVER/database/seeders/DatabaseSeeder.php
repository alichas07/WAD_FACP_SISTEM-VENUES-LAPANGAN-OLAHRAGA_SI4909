<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Administrator (Akses Penuh: Tambah, Edit, Hapus, Lihat, Cari)
        User::updateOrCreate(
            ['email' => 'admin@venue.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Buat Akun User Biasa (Akses Terbatas: Hanya Lihat Tabel & Cari)
        User::updateOrCreate(
            ['email' => 'user@venue.com'],
            [
                'name' => 'User 1',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );

    }
}
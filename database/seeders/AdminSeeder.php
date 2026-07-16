<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * AdminSeeder
 * Seeder untuk membuat user admin toko buku MediaBook
 *
 * digunakan untuk membuat akun admin default
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat atau perbarui user admin jika sudah ada
        User::updateOrCreate([
            'email' => 'admin@mediabook.com',
        ], [
            'name' => 'Admin MediaBook',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin',
        ]);

        // Tambahkan juga customer contoh
        User::updateOrCreate([
            'email' => 'customer@mediabook.com',
        ], [
            'name' => 'Buku Lover',
            'password' => Hash::make('password'), // Password: password
            'role' => 'customer',
        ]);

        $this->command->info('✓ Admin and customer accounts created successfully.');
        $this->command->info('  Admin Email: admin@mediabook.com');
        $this->command->info('  Customer Email: customer@mediabook.com');
        $this->command->info('  Password for both: password');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nik' => '123456789',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'is_admin' => 1,
            'is_mamber' => 0,
            'foto' => '20231108_WhatsApp Image 2023-08-05 at 13.26.14.jpg',
            'alamat' => 'Solo kidul sitik',
            'tgl_lahir' => '2023-11-08',
            'tlp' => '0812345',
            'is_active' => 1,
            'role' => 1,
        ]);
    }
}

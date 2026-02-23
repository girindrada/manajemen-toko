<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@mail.com',
            'password' => Hash::make('password'),
        ]);
    }
}

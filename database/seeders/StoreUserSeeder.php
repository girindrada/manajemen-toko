<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Store;
use App\Models\Store_user;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store_user::create([
            'store_id' => null,
            'user_id'  => 1,
            'role_id'  => 1,
        ]);

        Store_user::create([
            'store_id' => 1,
            'user_id'  => 2,
            'role_id'  => 2,
        ]);

        Store_user::create([
            'store_id' => 1,
            'user_id'  => 3,
            'role_id'  => 3,
        ]);
    }
}

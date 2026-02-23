<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'name' => 'Toko Pusat',
            'store_level_id' => 1,
            'created_by' => 1
        ]);

        Store::create([
            'name' => 'Toko Cabang Jogja',
            'store_level_id' => 2,
            'created_by' => 2
        ]);
    }
}

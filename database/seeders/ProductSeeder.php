<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Indomie Goreng',
            'price' => 3500,
            'store_id' => 1
        ]);

        Product::create([
            'name' => 'Teh Botol',
            'price' => 5000,
            'store_id' => 1
        ]);

    }
}

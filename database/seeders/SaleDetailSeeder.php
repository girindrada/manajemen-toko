<?php

namespace Database\Seeders;

use App\Models\Sale_detail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Sale_detail::create([
            'sale_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
            'price' => 3500,
            'subtotal' => 7000
        ]);
    }
}

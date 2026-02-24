<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::create([
            'invoice' => 'INV-001',
            'user_id' => 3,
            'store_id' => 1,
            'total_price' => 12000,
        ]);

        Sale::create([
            'invoice' => 'INV-002',
            'user_id' => 3,
            'store_id' => 2,
            'total_price' => 12000,
        ]);

        Sale::create([
            'invoice' => 'INV-003',
            'user_id' => 3,
            'store_id' => 1,
            'total_price' => 12000,
        ]);
    }
}

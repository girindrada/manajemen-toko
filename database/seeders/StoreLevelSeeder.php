<?php

namespace Database\Seeders;

use App\Models\Store_level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store_level::insert([
            ['name' => 'pusat'],
            ['name' => 'cabang'],
            ['name' => 'retail'],
        ]);
    }
}

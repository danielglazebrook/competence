<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales')->insert([
            'product_id' => rand(1,2),
            'quantity' => rand(1, 20),
            'unit_cost' => rand(10 * 10, 25 * 10) / 10,
            'created_at' => NOW()
        ]);
    }
}

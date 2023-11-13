<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $today = new DateTime;
        DB::table('stocks')->insert([
            'user_id' => 1,
            'ingredient_id' => 1,
            'expiration_at' => $today->modify('-2 days'),
            'quantity' => 5,
            'unit_id' => 23,
            'created_at' => $today->modify('-1 weeks'),
            'updated_at' => $today,
        ]);
        DB::table('stocks')->insert([
            'user_id' => 1,
            'ingredient_id' => 3,
            'expiration_at' => $today->modify('+1 year'),
            'quantity' => 3,
            'unit_id' => 27,
            'created_at' => $today,
            'updated_at' => $today,
        ]);
    }
}

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
        DB::table('stocks')->insert([
            'user_id' => 1,
            'ingredient_id' => 1,
            'expiration_at' => date("2023-09-26"),
            'quantity' => 1,
            'unit' => "匹",
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

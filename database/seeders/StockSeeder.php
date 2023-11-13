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
            'expiration_at' => (new DateTime())->modify('-2 days'),
            'quantity' => 5,
            'unit_id' => 23,
            'created_at' => (new DateTime())->modify('-1 week'),
            'updated_at' => new DateTime(),
        ]);
        DB::table('stocks')->insert([
            'user_id' => 1,
            'ingredient_id' => 3,
            'expiration_at' => (new DateTime())->modify('+3 months'),
            'quantity' => 3,
            'unit_id' => 27,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

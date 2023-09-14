<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class ShoppingListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shopping_lists')->insert([
            'user_id' => 1,
            'ingredient_id' => 1,
            'status' => 0,
            'number' => 3,
            'unit' => '匹',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}

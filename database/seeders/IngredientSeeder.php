<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ingredients')->insert([
            'ingredient_category_id' => 4,
            'name' => 'マグロ',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('ingredients')->insert([
            'ingredient_category_id' => 18,
            'name' => '醤油',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('ingredients')->insert([
            'ingredient_category_id' => 8,
            'name' => 'カップ麺',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('ingredients')->insert([
            'ingredient_category_id' => 16,
            'name' => 'プロテイン',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        
    }
}

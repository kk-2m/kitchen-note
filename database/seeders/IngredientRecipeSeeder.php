<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class IngredientRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ingredient_recipe')->insert([
            'recipe_id' => 1,
            'ingredient_id' => 3,
            'quantity' => 1,
            'unit_id' => 26,
        ]);
        DB::table('ingredient_recipe')->insert([
            'recipe_id' => 2,
            'ingredient_id' => 1,
            'quantity' => 1,
            'unit_id' => 17,
        ]);
        DB::table('ingredient_recipe')->insert([
            'recipe_id' => 2,
            'ingredient_id' => 2,
            'quantity' => 1,
            'unit_id' => 15,
        ]);
        DB::table('ingredient_recipe')->insert([
            'recipe_id' => 3,
            'ingredient_id' => 4,
            'quantity' => 20,
            'unit_id' => 2,
        ]);
    }
}

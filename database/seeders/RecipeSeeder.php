<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipes')->insert([
            'user_id' => 1,
            'title' => 'カップ麺の作り方',
            'number' => 1,
            'cooking_time' => 3,
            'cooking_time_unit' => 2,
            'image' => '1/cup_noodle.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('recipes')->insert([
            'user_id' => 1,
            'title' => 'マグロの刺身の作り方',
            'number' => 1,
            'cooking_time' => 3,
            'cooking_time_unit' => 2,
            'image' => '1/tuna_img.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('recipes')->insert([
            'user_id' => 1,
            'title' => 'プロテインの飲み方',
            'number' => 1,
            'cooking_time' => 2,
            'cooking_time_unit' => 2,
            'image' => '1/protein.jpg',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

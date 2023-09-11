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
            'cooking_time' => 3,
            'cooking_time_unit' => 'm',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

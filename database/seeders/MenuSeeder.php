<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'recipe_id' => 2,
            'user_id' => 1,
            'number' => 4,
            'date' => date('2024-10-10'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('menus')->insert([
            'recipe_id' => 3,
            'user_id' => 1,
            'number' => 4,
            'date' => date('2023-10-14'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

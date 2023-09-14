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
            'day' => '金',
            'date' => date('2023-09-25'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => '肉料理',
        ]);
        DB::table('categories')->insert([
            'name' => '魚料理',
        ]);
        DB::table('categories')->insert([
            'name' => '卵料理',
        ]);
        DB::table('categories')->insert([
            'name' => 'ご飯もの',
        ]);
        DB::table('categories')->insert([
            'name' => 'パスタ',
        ]);
        DB::table('categories')->insert([
            'name' => '麺・粉物料理',
        ]);
        DB::table('categories')->insert([
            'name' => '汁物・スープ',
        ]);
        DB::table('categories')->insert([
            'name' => '鍋料理',
        ]);
        DB::table('categories')->insert([
            'name' => 'サラダ',
        ]);
        DB::table('categories')->insert([
            'name' => 'パン',
        ]);
        DB::table('categories')->insert([
            'name' => 'お菓子',
        ]);
        DB::table('categories')->insert([
            'name' => 'その他',
        ]);
    }
}

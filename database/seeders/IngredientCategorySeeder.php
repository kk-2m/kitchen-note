<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class IngredientCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ingredient_categories')->insert([
            'category' => '米・雑穀・シリアル',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '麺類',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '野菜',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '水産物・水産物加工品',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '肉・肉加工品',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '卵・チーズ・乳製品',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '果物',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '惣菜・レトルト・冷凍',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '豆腐',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '納豆・漬物・佃煮（ご飯のお供）',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => 'メンマ・こんにゃく・油揚げ等',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => 'パン',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => 'ジャム・はちみつ等',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '粉類',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '乾物',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => 'ダイエットフード',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '缶詰・瓶詰',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '調味料',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => 'おかし',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => 'お酒',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => '水・ソフトドリンク等',
        ]);
        DB::table('ingredient_categories')->insert([
            'category' => 'その他',
        ]);
    }
}

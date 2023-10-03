<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'name' => "ミリグラム",
            'abbreviation' => "mg",
        ]);
        DB::table('units')->insert([
            'name' => "グラム",
            'abbreviation' => "g",
        ]);
        DB::table('units')->insert([
            'name' => "キログラム",
            'abbreviation' => "kg",
        ]);
        DB::table('units')->insert([
            'name' => "トン",
            'abbreviation' => "t",
        ]);
        DB::table('units')->insert([
            'name' => "シーシー",
            'abbreviation' => "cc",
        ]);
        DB::table('units')->insert([
            'name' => "ミリリットル",
            'abbreviation' => "mL",
        ]);
        DB::table('units')->insert([
            'name' => "デシリットル",
            'abbreviation' => "dL",
        ]);
        DB::table('units')->insert([
            'name' => "リットル",
            'abbreviation' => "L",
        ]);
        DB::table('units')->insert([
            'name' => "キロリットル",
            'abbreviation' => "kL",
        ]);
        DB::table('units')->insert([
            'name' => "ミリメートル",
            'abbreviation' => "mm",
        ]);
        DB::table('units')->insert([
            'name' => "センチメートル",
            'abbreviation' => "cm",
        ]);
        DB::table('units')->insert([
            'name' => "メートル",
            'abbreviation' => "m",
        ]);
        DB::table('units')->insert([
            'name' => "キロメートル",
            'abbreviation' => "km",
        ]);
        DB::table('units')->insert([
            'name' => "大さじ",
        ]);
        DB::table('units')->insert([
            'name' => "小さじ",
        ]);
        DB::table('units')->insert([
            'name' => "適量",
        ]);
        DB::table('units')->insert([
            'name' => "匹",
        ]);
        DB::table('units')->insert([
            'name' => "尾",
        ]);
        DB::table('units')->insert([
            'name' => "羽",
        ]);
        DB::table('units')->insert([
            'name' => "頭",
        ]);
        DB::table('units')->insert([
            'name' => "杯",
        ]);
        DB::table('units')->insert([
            'name' => "玉",
        ]);
        DB::table('units')->insert([
            'name' => "切れ",
        ]);
        DB::table('units')->insert([
            'name' => "さく",
        ]);
        DB::table('units')->insert([
            'name' => "枚",
        ]);
        DB::table('units')->insert([
            'name' => "つ",
        ]);
        DB::table('units')->insert([
            'name' => "個",
        ]);
        DB::table('units')->insert([
            'name' => "本",
        ]);
        DB::table('units')->insert([
            'name' => "丁",
        ]);
    }
}

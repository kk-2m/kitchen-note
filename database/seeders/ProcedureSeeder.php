<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class ProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('procedures')->insert([
            'body' => 'カップ麺にお湯を注ぎます' ,
            'recipe_id' => 1,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        Db::table('procedures')->insert([
            'body' => '3分待ったら出来上がり',
            'recipe_id' => 1,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('procedures')->insert([
            'body' => 'マグロの下処理をします' ,
            'recipe_id' => 2,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        Db::table('procedures')->insert([
            'body' => '刺身の形に切れば完成',
            'recipe_id' => 2,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}

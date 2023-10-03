<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UnitConversionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 1,
            'to_unit_id' => 2,
            'conversion_factor' => 1000,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 2,
            'to_unit_id' => 3,
            'conversion_factor' => 1000,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 3,
            'to_unit_id' => 4,
            'conversion_factor' => 1000,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 5,
            'to_unit_id' => 6,
            'conversion_factor' => 1,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 5,
            'to_unit_id' => 7,
            'conversion_factor' => 100,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 5,
            'to_unit_id' => 8,
            'conversion_factor' => 1000,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 6,
            'to_unit_id' => 7,
            'conversion_factor' => 100,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 6,
            'to_unit_id' => 8,
            'conversion_factor' => 1000,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 7,
            'to_unit_id' => 8,
            'conversion_factor' => 10,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 8,
            'to_unit_id' => 9,
            'conversion_factor' => 1000,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 10,
            'to_unit_id' => 11,
            'conversion_factor' => 10,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 11,
            'to_unit_id' => 12,
            'conversion_factor' => 100,
        ]);
        DB::table('unit_conversions')->insert([
            'from_unit_id' => 12,
            'to_unit_id' => 13,
            'conversion_factor' => 1000,
        ]);
    }
}

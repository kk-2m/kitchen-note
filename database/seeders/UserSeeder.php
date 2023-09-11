<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'koki',
            'email' => 'kishi.koki6@gmail.com',
            'password' => '88180103',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}

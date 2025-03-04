<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EcMasterTableTruncateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // マスターテーブル初期化
        DB::table('ec_prefs')->truncate();
        DB::table('ec_cities')->truncate();
        DB::table('ec_zips')->truncate();
    }
}

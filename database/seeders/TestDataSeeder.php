<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sql = file_get_contents(database_path('schemas/mardinkent_init.sql'));
        DB::unprepared($sql);
    }
}

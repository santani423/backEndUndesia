<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tema1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('temas')->insert([
            'name' => 'Tema 1',
            'code' => 'TEMA1',
        ]);
    }
}
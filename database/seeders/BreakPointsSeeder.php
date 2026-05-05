<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreakPointsSeeder extends Seeder
{
    public function run(): void
    {
        $breakpoints = [
            ['name' => 'xxs',    'code' => 'xxs',    'sekala' => '360px'],
            ['name' => 'xs',     'code' => 'xs',     'sekala' => '375px'],
            ['name' => 's',      'code' => 's',      'sekala' => '390px'],
            ['name' => 'iphone', 'code' => 'iphone', 'sekala' => '412px'],
            ['name' => 'md',     'code' => 'md',     'sekala' => '768px'],
            ['name' => 'md2',    'code' => 'md2',    'sekala' => '810px'],
            ['name' => 'md3',    'code' => 'md3',    'sekala' => '850px'],
            ['name' => 'tb',     'code' => 'tb',     'sekala' => '900px'],
        ];

        DB::table('breack_poins')->insert($breakpoints);
    }
}
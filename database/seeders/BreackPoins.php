<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreakPointsSeeder extends Seeder
{
    public function run(): void
    {
        $breakpoints = [
            ['name' => 'xxs',    'code' => 'xxs',    'size' => '360px'],
            ['name' => 'xs',     'code' => 'xs',     'size' => '375px'],
            ['name' => 's',      'code' => 's',      'size' => '390px'],
            ['name' => 'iphone', 'code' => 'iphone', 'size' => '412px'],
            ['name' => 'md',     'code' => 'md',     'size' => '768px'],
            ['name' => 'md2',    'code' => 'md2',    'size' => '810px'],
            ['name' => 'md3',    'code' => 'md3',    'size' => '850px'],
            ['name' => 'tb',     'code' => 'tb',     'size' => '900px'],
        ];

        DB::table('breack_poins')->insert($breakpoints);
    }
}
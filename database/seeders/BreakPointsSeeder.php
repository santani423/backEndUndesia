<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreakPointsSeeder extends Seeder
{
    public function run(): void
    {
        // hapus data lama
        DB::table('breack_poins')->truncate();

        $breakpoints = [
            ['name' => 'xxxs',   'code' => 'xxxs',   'sekala' => '340px'],
            ['name' => 'xxs',    'code' => 'xxs',    'sekala' => '360px'], // Samsung Galaxy S20
            ['name' => 'xs',     'code' => 'xs',     'sekala' => '375px'], // iPhone SE
            ['name' => 's',      'code' => 's',      'sekala' => '390px'], // iPhone 12 Pro
            ['name' => 's2',     'code' => 's2',     'sekala' => '392px'], // Poco
            ['name' => 'iphone', 'code' => 'iphone', 'sekala' => '412px'], // iPhone XR / 14 Pro Max range
            ['name' => 'mobile',  'code' => 'mobile', 'sekala' => '540px'], // Surface Duo
            ['name' => 'sm',     'code' => 'sm',     'sekala' => '640px'], // Huawei portrait
            ['name' => 'md',     'code' => 'md',     'sekala' => '768px'], // iPad mini
            ['name' => 'md2',    'code' => 'md2',    'sekala' => '810px'], // iPad Air
            ['name' => 'md3',    'code' => 'md3',    'sekala' => '850px'], // Asus Zenbook
            ['name' => 'tb',     'code' => 'tb',     'sekala' => '900px'], // Surface Pro
            ['name' => 'lg',     'code' => 'lg',     'sekala' => '1024px'], // iPad Pro
            ['name' => 'lg2',    'code' => 'lg2',    'sekala' => '1090px'],
            ['name' => 'lg3',    'code' => 'lg3',    'sekala' => '1098px'],
            ['name' => 'xl',     'code' => 'xl',     'sekala' => '1270px'],
            ['name' => '2xl',    'code' => '2xl',    'sekala' => '1281px'],
            ['name' => '3xl',    'code' => '3xl',    'sekala' => '1600px'],
            ['name' => '4xl',    'code' => '4xl',    'sekala' => '2200px'],
            ['name' => '5xl',    'code' => '5xl',    'sekala' => '2400px'], // monitor 24 inch
        ];

        DB::table('breack_poins')->insert($breakpoints);
    }
}
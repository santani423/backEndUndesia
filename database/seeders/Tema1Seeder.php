<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\BreakPoint;
use App\Models\SizeTema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tema1Seeder extends Seeder
{
    public function run(): void
    {
        // Insert tema
        $temaId = DB::table('temas')->insertGetId([
            'name' => 'Tema 1',
            'code' => 'TEMA1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert assets
        $assetsData = [
            [
                'tema_id' => $temaId,
                'path' => 'alamat.png',
                'name' => 'alamat',
                'type' => 'item',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tema_id' => $temaId,
                'path' => 'bg.png',
                'name' => 'bg',
                'type' => 'bg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('assets')->insert($assetsData);

        // Ambil ulang assets & breakpoint
        $assets = Asset::where('tema_id', $temaId)->get();
        $breakpoints = BreakPoint::all();

        // Ambil size tema default (misalnya top-1)
        $defaultSize = SizeTema::where('type', 'top')->where('no', 1)->first();

        if (!$defaultSize) {
            throw new \Exception('SizeTema default tidak ditemukan');
        }

        $insertData = [];

        foreach ($assets as $asset) {
            foreach ($breakpoints as $bp) {
                $insertData[] = [
                    'asset_id' => $asset->id,
                    'size_tema_id' => $defaultSize->id,
                    'break_point_id' => $bp->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Bulk insert (jauh lebih efisien)
        DB::table('asset_sizes')->insert($insertData);
    }
}
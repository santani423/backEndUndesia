<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\BreackPoin;
use App\Models\SizeTema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tema1Seeder extends Seeder
{
    public function run(): void
    {
        DB::table('temas')->truncate();
        DB::table('assets')->truncate();
        DB::table('asset_sizes')->truncate();

        $temaId = DB::table('temas')->insertGetId([
            'name'       => 'Tema 1',
            'code'       => 'TEMA1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->insertAssets($temaId);

        $assets      = Asset::where('tema_id', $temaId)->get()->keyBy('name');
        $breakpoints = BreackPoin::all()->keyBy('code');

        $insertData = $this->buildAssetSizes($assets, $breakpoints);

        DB::table('asset_sizes')->insert($insertData);
    }

    private function insertAssets(int $temaId): void
    {
        $names = ['clothes-rack', 'address', 'rsvp', 'couple', 'love-story', 'gift', 'gallery'];

        foreach ($names as $name) {
            DB::table('assets')->insert([
                'tema_id'    => $temaId,
                'path'       => $name . '.webp',
                'name'       => $name,
                'type'       => 'item',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function buildAssetSizes(\Illuminate\Support\Collection $assets, \Illuminate\Support\Collection $breakpoints): array
    {
        $sizeTemaCache = [];
        $insertData    = [];

        foreach ($this->componentStyles() as $assetName => $bpStyles) {
            $asset = $assets[$assetName] ?? null;
            if (!$asset) {
                continue;
            }

            foreach ($bpStyles as $bpCode => $styles) {
                $bp = $breakpoints[$bpCode] ?? null;
                if (!$bp) {
                    continue;
                }

                foreach ($styles as $type => $numericValue) {
                    $sizeId = $this->resolveSizeTemaId($type, $numericValue, $sizeTemaCache);

                    $insertData[] = [
                        'asset_id'       => $asset->id,
                        'size_tema_id'   => $sizeId,
                        'breack_poin_id' => $bp->id,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }
            }
        }

        return $insertData;
    }

    private function resolveSizeTemaId(string $type, int|float $numericValue, array &$cache): int
    {
        $negative = $numericValue < 0;
        $abs      = abs($numericValue);
        $absStr   = (floor($abs) == $abs) ? (string)(int)$abs : (string)$abs;
        $valueStr = ($negative ? '-' : '') . $type . '-' . $absStr;

        if (!isset($cache[$valueStr])) {
            $cache[$valueStr] = SizeTema::firstOrCreate(
                ['value' => $valueStr, 'type' => $type],
                ['no'    => $negative ? -(int)$absStr : (int)$absStr]
            )->id;
        }

        return $cache[$valueStr];
    }

    private function componentStyles(): array
    {
        return [
            'clothes-rack' => [
                'default' => ['top' => 68, 'right' => 1,  'w' => 32],
                'xxs'     => ['top' => 46],
                'xs'      => ['top' => 30, 'w' => 38],
                's'       => ['top' => 52],
                's2'      => ['top' => 42],
                'iphone'  => ['top' => 60, 'w' => 40],
                'mobile'  => ['top' => 42, 'w' => 34],
                'sm'      => ['top' => 66, 'w' => 42],
                'md'      => ['top' => 44, 'right' => 3,  'w' => 50],
                'md2'     => ['top' => 64, 'w' => 50],
                'md3'     => ['top' => 60, 'w' => 60],
                'tb'      => ['top' => 72, 'w' => 60],
                'lg'      => ['top' => 88, 'w' => 60],
                'lg2'     => ['top' => 34, 'w' => 28],
                'lg3'     => ['top' => 40],
                'xl'      => ['top' => 44, 'right' => -2, 'w' => 30],
                '3xl'     => ['top' => 58, 'w' => 40],
                '5xl'     => ['top' => 82, 'w' => 50],
            ],
            'address' => [
                'default' => ['top' => 0,  'right' => 7, 'w' => 26],
                'sm'      => ['w' => 32],
                'md'      => ['w' => 36],
                'tb'      => ['w' => 40],
                'lg'      => ['w' => 52],
                'lg2'     => ['w' => 20],
                'xl'      => ['right' => 3, 'w' => 22],
                '3xl'     => ['right' => 4, 'w' => 26],
                '5xl'     => ['w' => 40],
            ],
            'rsvp' => [
                'default' => ['left' => 3,  'w' => 24],
                'xxs'     => ['left' => 12],
                's'       => ['w' => 26],
                's2'      => ['w' => 20],
                'iphone'  => ['w' => 28],
                'mobile'  => ['w' => 20],
                'sm'      => ['w' => 28],
                'md'      => ['left' => 20, 'w' => 30],
                'md2'     => ['w' => 32],
                'tb'      => ['w' => 40],
                'lg'      => ['w' => 40],
                'lg2'     => ['left' => 10, 'w' => 18],
                'xl'      => ['left' => 12, 'w' => 20],
                '3xl'     => ['left' => 16, 'w' => 24],
                '5xl'     => ['w' => 32],
            ],
            'couple' => [
                'default' => ['w' => 32],
                'xxs'     => ['bottom' => 72,  'right' => 24, 'w' => 36],
                'xs'      => ['bottom' => 60,  'right' => 28, 'w' => 40],
                's'       => ['bottom' => 86,  'w' => 34],
                's2'      => ['bottom' => 72,  'right' => 38, 'w' => 30],
                'iphone'  => ['bottom' => 90,  'right' => 34, 'w' => 38],
                'mobile'  => ['bottom' => 70,  'right' => 26, 'w' => 30],
                'sm'      => ['bottom' => 96,  'right' => 44, 'w' => 42],
                'md'      => ['bottom' => 90,  'right' => 38, 'w' => 46],
                'md2'     => ['top' => 100,    'right' => 40, 'w' => 50],
                'md3'     => ['top' => 28,     'w' => 54],
                'tb'      => ['top' => 115,    'right' => 68, 'w' => 60],
                'lg'      => ['top' => 130,    'right' => 48, 'w' => 60],
                'lg2'     => ['top' => 56,     'right' => 28, 'w' => 28],
                'lg3'     => ['top' => 62,     'right' => 18],
                'xl'      => ['top' => 66,     'right' => 30, 'w' => 30],
                '3xl'     => ['top' => 85,     'right' => 50, 'w' => 34],
                '5xl'     => ['top' => 118,    'right' => 46, 'w' => 50],
            ],
            'loveStory' => [
                'default' => ['bottom' => 80,  'right' => -8, 'w' => 40],
                'xxs'     => ['bottom' => 64,  'right' => -4, 'w' => 36],
                'xs'      => ['bottom' => 56,  'right' => -4],
                's'       => ['bottom' => 74,  'right' => -2, 'w' => 38],
                's2'      => ['bottom' => 58,  'right' => 2,  'w' => 36],
                'iphone'  => ['bottom' => 78,  'right' => -5, 'w' => 44],
                'mobile'  => ['bottom' => 62,  'right' => -2, 'w' => 34],
                'sm'      => ['bottom' => 80,  'right' => 0,  'w' => 42],
                'md'      => ['bottom' => 70,  'right' => -3, 'w' => 50],
                'md2'     => ['bottom' => 90,  'right' => -6, 'w' => 58],
                'tb'      => ['bottom' => 90,  'right' => -8, 'w' => 78],
                'lg'      => ['bottom' => 116, 'right' => -6, 'w' => 66],
                'lg2'     => ['bottom' => 42,  'right' => -1, 'w' => 30],
                'lg3'     => ['bottom' => 52,  'w' => 26],
                'xl'      => ['bottom' => 56,  'right' => 0,  'w' => 32],
                '3xl'     => ['bottom' => 70,  'right' => -1, 'w' => 40],
                '5xl'     => ['bottom' => 100, 'w' => 54],
            ],
            'gift' => [
                'default' => ['bottom' => 56, 'right' => 0,  'w' => 28],
                'xxs'     => ['bottom' => 44, 'right' => 4,  'w' => 24],
                'xs'      => ['bottom' => 36],
                's'       => ['bottom' => 40, 'right' => 6,  'w' => 24],
                's2'      => ['w' => 24],
                'iphone'  => ['bottom' => 54, 'right' => 3,  'w' => 30],
                'mobile'  => ['bottom' => 44, 'w' => 24],
                'sm'      => ['bottom' => 56, 'right' => 12, 'w' => 30],
                'md'      => ['bottom' => 48, 'right' => 10, 'w' => 30],
                'md2'     => ['bottom' => 62, 'w' => 35],
                'tb'      => ['bottom' => 58, 'right' => 10, 'w' => 42],
                'lg'      => ['bottom' => 82, 'w' => 40],
                'lg2'     => ['bottom' => 28, 'right' => 6,  'w' => 16],
                'lg3'     => ['bottom' => 40],
                'xl'      => ['bottom' => 38, 'w' => 20],
                '3xl'     => ['bottom' => 40, 'right' => 8,  'w' => 28],
                '5xl'     => ['bottom' => 74, 'right' => 10, 'w' => 32],
            ],
            'gallery' => [
                'default' => ['top' => 40, 'left' => 6,  'w' => 32],
                'xxs'     => ['top' => 32, 'left' => 10],
                'xs'      => ['top' => 20, 'left' => 12],
                's'       => ['top' => 40, 'left' => 12],
                's2'      => ['top' => 28],
                'iphone'  => ['top' => 44, 'left' => 12, 'w' => 36],
                'mobile'  => ['top' => 32, 'left' => 8,  'w' => 32],
                'sm'      => ['top' => 42, 'left' => 14, 'w' => 42],
                'md'      => ['top' => 32, 'left' => 16, 'w' => 40],
                'md2'     => ['top' => 44, 'w' => 48],
                'md3'     => ['top' => 44, 'w' => 56],
                'tb'      => ['top' => 36, 'left' => 26],
                'lg'      => ['top' => 62, 'left' => 20, 'w' => 56],
                'lg2'     => ['top' => 20, 'left' => 10, 'w' => 26],
                'lg3'     => ['top' => 30, 'left' => 6],
                'xl'      => ['top' => 26, 'left' => 10, 'w' => 30],
                '3xl'     => ['top' => 26, 'left' => 20, 'w' => 36],
                '5xl'     => ['top' => 58, 'left' => 22, 'w' => 42],
            ],
        ];
    }
}

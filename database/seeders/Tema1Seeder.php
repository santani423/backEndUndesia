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
                'path'       => '/storages/Thems/TEMA1/'.$name.'.webp',
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
                'default' => ['top' => 68, 'bottom' => 0, 'right' => 1,  'w' => 32],
                'xxs'     => ['top' => 46, 'bottom' => 0, 'right' => 1,  'w' => 32],
                'xs'      => ['top' => 30, 'bottom' => 0, 'right' => 1,  'w' => 38],
                's'       => ['top' => 52, 'bottom' => 0, 'right' => 1,  'w' => 34],
                's2'      => ['top' => 42, 'bottom' => 0, 'right' => 1,  'w' => 30],
                'iphone'  => ['top' => 60, 'bottom' => 0, 'right' => 1,  'w' => 40],
                'mobile'  => ['top' => 42, 'bottom' => 0, 'right' => 1,  'w' => 34],
                'sm'      => ['top' => 66, 'bottom' => 0, 'right' => 1,  'w' => 42],
                'md'      => ['top' => 44, 'bottom' => 0, 'right' => 3,  'w' => 50],
                'md2'     => ['top' => 64, 'bottom' => 0, 'right' => 1,  'w' => 50],
                'md3'     => ['top' => 60, 'bottom' => 0, 'right' => 1,  'w' => 60],
                'tb'      => ['top' => 72, 'bottom' => 0, 'right' => 1,  'w' => 60],
                'lg'      => ['top' => 88, 'bottom' => 0, 'right' => 1,  'w' => 60],
                'lg2'     => ['top' => 34, 'bottom' => 0, 'right' => 1,  'w' => 28],
                'lg3'     => ['top' => 40, 'bottom' => 0, 'right' => 1,  'w' => 24],
                'xl'      => ['top' => 44, 'bottom' => 0, 'right' => -2, 'w' => 30],
                '3xl'     => ['top' => 58, 'bottom' => 0, 'right' => 1,  'w' => 40],
                '5xl'     => ['top' => 82, 'bottom' => 0, 'right' => 1,  'w' => 50],
            ],
            'address' => [
                'default' => ['top' => 0, 'bottom' => 0, 'right' => 7, 'w' => 26],
                'sm'      => ['top' => 0, 'bottom' => 0, 'right' => 5, 'w' => 32],
                'md'      => ['top' => 0, 'bottom' => 0, 'right' => 1, 'w' => 36],
                'tb'      => ['top' => 0, 'bottom' => 0, 'right' => 1, 'w' => 40],
                'lg'      => ['top' => 0, 'bottom' => 0, 'right' => 1, 'w' => 52],
                'lg2'     => ['top' => 0, 'bottom' => 0, 'right' => 1, 'w' => 20],
                'xl'      => ['top' => 0, 'bottom' => 0, 'right' => 3, 'w' => 22],
                '3xl'     => ['top' => 0, 'bottom' => 0, 'right' => 4, 'w' => 26],
                '5xl'     => ['top' => 0, 'bottom' => 0, 'w' => 40],
            ],
            'rsvp' => [
                'default' => ['top' => 0, 'bottom' => 0, 'left' => 3,  'w' => 24],
                'xxs'     => ['top' => 0, 'bottom' => 0, 'left' => 12, 'w' => 20],
                's'       => ['top' => 0, 'bottom' => 0, 'left' => 6,  'w' => 26],
                's2'      => ['top' => 0, 'bottom' => 0, 'left' => 6,  'w' => 20],
                'iphone'  => ['top' => 0, 'bottom' => 0, 'left' => 8,  'w' => 28],
                'mobile'  => ['top' => 0, 'bottom' => 0, 'left' => 6,  'w' => 20],
                'sm'      => ['top' => 0, 'bottom' => 0, 'left' => 10, 'w' => 28],
                'md'      => ['top' => 0, 'bottom' => 0, 'left' => 20, 'w' => 30],
                'md2'     => ['top' => 0, 'bottom' => 0, 'left' => 20, 'w' => 32],
                'tb'      => ['top' => 0, 'bottom' => 0, 'left' => 20, 'w' => 40],
                'lg'      => ['top' => 0, 'bottom' => 0, 'left' => 20, 'w' => 40],
                'lg2'     => ['top' => 0, 'bottom' => 0, 'left' => 10, 'w' => 18],
                'xl'      => ['top' => 0, 'bottom' => 0, 'left' => 12, 'w' => 20],
                '3xl'     => ['top' => 0, 'bottom' => 0, 'left' => 16, 'w' => 24],
                '5xl'     => ['top' => 0, 'bottom' => 0, 'left' => 20, 'w' => 32],
            ],
            'couple' => [
                'default' => ['top' => 0,   'bottom' => 0,  'w' => 32],
                'xxs'     => ['top' => 0,   'bottom' => 72, 'right' => 24, 'w' => 36],
                'xs'      => ['top' => 0,   'bottom' => 60, 'right' => 28, 'w' => 40],
                's'       => ['top' => 0,   'bottom' => 86, 'w' => 34],
                's2'      => ['top' => 0,   'bottom' => 72, 'right' => 38, 'w' => 30],
                'iphone'  => ['top' => 0,   'bottom' => 90, 'right' => 34, 'w' => 38],
                'mobile'  => ['top' => 0,   'bottom' => 70, 'right' => 26, 'w' => 30],
                'sm'      => ['top' => 0,   'bottom' => 96, 'right' => 44, 'w' => 42],
                'md'      => ['top' => 0,   'bottom' => 90, 'right' => 38, 'w' => 46],
                'md2'     => ['top' => 100, 'bottom' => 0,  'right' => 40, 'w' => 50],
                'md3'     => ['top' => 28,  'bottom' => 0,  'w' => 54],
                'tb'      => ['top' => 115, 'bottom' => 0,  'right' => 68, 'w' => 60],
                'lg'      => ['top' => 130, 'bottom' => 0,  'right' => 48, 'w' => 60],
                'lg2'     => ['top' => 56,  'bottom' => 0,  'right' => 28, 'w' => 28],
                'lg3'     => ['top' => 62,  'bottom' => 0,  'right' => 18],
                'xl'      => ['top' => 66,  'bottom' => 0,  'right' => 30, 'w' => 30],
                '3xl'     => ['top' => 85,  'bottom' => 0,  'right' => 50, 'w' => 34],
                '5xl'     => ['top' => 118, 'bottom' => 0,  'right' => 46, 'w' => 50],
            ],
            'loveStory' => [
                'default' => ['top' => 0, 'bottom' => 80,  'right' => -8, 'w' => 40],
                'xxs'     => ['top' => 0, 'bottom' => 64,  'right' => -4, 'w' => 36],
                'xs'      => ['top' => 0, 'bottom' => 56,  'right' => -4],
                's'       => ['top' => 0, 'bottom' => 74,  'right' => -2, 'w' => 38],
                's2'      => ['top' => 0, 'bottom' => 58,  'right' => 2,  'w' => 36],
                'iphone'  => ['top' => 0, 'bottom' => 78,  'right' => -5, 'w' => 44],
                'mobile'  => ['top' => 0, 'bottom' => 62,  'right' => -2, 'w' => 34],
                'sm'      => ['top' => 0, 'bottom' => 80,  'right' => 0,  'w' => 42],
                'md'      => ['top' => 0, 'bottom' => 70,  'right' => -3, 'w' => 50],
                'md2'     => ['top' => 0, 'bottom' => 90,  'right' => -6, 'w' => 58],
                'tb'      => ['top' => 0, 'bottom' => 90,  'right' => -8, 'w' => 78],
                'lg'      => ['top' => 0, 'bottom' => 116, 'right' => -6, 'w' => 66],
                'lg2'     => ['top' => 0, 'bottom' => 42,  'right' => -1, 'w' => 30],
                'lg3'     => ['top' => 0, 'bottom' => 52,  'w' => 26],
                'xl'      => ['top' => 0, 'bottom' => 56,  'right' => 0,  'w' => 32],
                '3xl'     => ['top' => 0, 'bottom' => 70,  'right' => -1, 'w' => 40],
                '5xl'     => ['top' => 0, 'bottom' => 100, 'w' => 54],
            ],
            'gift' => [
                'default' => ['top' => 0, 'bottom' => 56, 'right' => 0,  'w' => 28],
                'xxs'     => ['top' => 0, 'bottom' => 44, 'right' => 4,  'w' => 24],
                'xs'      => ['top' => 0, 'bottom' => 36],
                's'       => ['top' => 0, 'bottom' => 40, 'right' => 6,  'w' => 24],
                's2'      => ['top' => 0, 'bottom' => 0,  'w' => 24],
                'iphone'  => ['top' => 0, 'bottom' => 54, 'right' => 3,  'w' => 30],
                'mobile'  => ['top' => 0, 'bottom' => 44, 'w' => 24],
                'sm'      => ['top' => 0, 'bottom' => 56, 'right' => 12, 'w' => 30],
                'md'      => ['top' => 0, 'bottom' => 48, 'right' => 10, 'w' => 30],
                'md2'     => ['top' => 0, 'bottom' => 62, 'w' => 35],
                'tb'      => ['top' => 0, 'bottom' => 58, 'right' => 10, 'w' => 42],
                'lg'      => ['top' => 0, 'bottom' => 82, 'w' => 40],
                'lg2'     => ['top' => 0, 'bottom' => 28, 'right' => 6,  'w' => 16],
                'lg3'     => ['top' => 0, 'bottom' => 40],
                'xl'      => ['top' => 0, 'bottom' => 38, 'w' => 20],
                '3xl'     => ['top' => 0, 'bottom' => 40, 'right' => 8,  'w' => 28],
                '5xl'     => ['top' => 0, 'bottom' => 74, 'right' => 10, 'w' => 32],
            ],
            'gallery' => [
                'default' => ['top' => 40, 'bottom' => 0, 'left' => 6,  'w' => 32],
                'xxs'     => ['top' => 32, 'bottom' => 0, 'left' => 10, 'w' => 26],
                'xs'      => ['top' => 20, 'bottom' => 0, 'left' => 12, 'w' => 28],
                's'       => ['top' => 40, 'bottom' => 0, 'left' => 12, 'w' => 30],
                's2'      => ['top' => 28, 'bottom' => 0, 'left' => 10, 'w' => 28],
                'iphone'  => ['top' => 44, 'bottom' => 0, 'left' => 12, 'w' => 36],
                'mobile'  => ['top' => 32, 'bottom' => 0, 'left' => 8,  'w' => 32],
                'sm'      => ['top' => 42, 'bottom' => 0, 'left' => 14, 'w' => 42],
                'md'      => ['top' => 32, 'bottom' => 0, 'left' => 16, 'w' => 40],
                'md2'     => ['top' => 44, 'bottom' => 0, 'left' => 18, 'w' => 48],
                'md3'     => ['top' => 44, 'bottom' => 0, 'left' => 22, 'w' => 56],
                'tb'      => ['top' => 36, 'bottom' => 0, 'left' => 26, 'w' => 50],
                'lg'      => ['top' => 62, 'bottom' => 0, 'left' => 20, 'w' => 56],
                'lg2'     => ['top' => 20, 'bottom' => 0, 'left' => 10, 'w' => 26],
                'lg3'     => ['top' => 30, 'bottom' => 0, 'left' => 6,  'w' => 28],
                'xl'      => ['top' => 26, 'bottom' => 0, 'left' => 10, 'w' => 30],
                '3xl'     => ['top' => 26, 'bottom' => 0, 'left' => 20, 'w' => 36],
                '5xl'     => ['top' => 58, 'bottom' => 0, 'left' => 22, 'w' => 42],
            ],
        ];
    }
}

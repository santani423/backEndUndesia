<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeTemaSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['top', 'bottom', 'right', 'left', 'w'];

        // Tailwind CSS complete spacing/sizing scale
        $values = [
            "px","0","0.5","1","1.5","2","2.5","3","3.5","4","5","6","7","8","9","10",
            "11","12","14","16","20","24","28","32","36","40","44","48","52","56","60",
            "64","72","80","96",
            // Fractions (width/height)
            "1/2","1/3","2/3","1/4","2/4","3/4","1/5","2/5","3/5","4/5",
            "1/6","2/6","3/6","4/6","5/6","1/12","2/12","3/12","4/12","5/12",
            "6/12","7/12","8/12","9/12","10/12","11/12",
            "full","screen","svh","lvh","dvh","min","max","fit",
        ];

        $negativeValues = [
            "px","0.5","1","1.5","2","2.5","3","3.5","4","5","6","7","8","9","10",
            "11","12","14","16","20","24","28","32","36","40","44","48","52","56",
            "60","64","72","80","96",
        ];

        $data = [];

        foreach ($types as $type) {
            foreach ($values as $index => $value) {
                $data[] = [
                    'type'  => $type,
                    'no'    => $index + 1,
                    'value' => $type . '-' . $value,
                ];
            }
            if (in_array($type, ['top', 'bottom', 'right', 'left'])) {
                foreach ($negativeValues as $index => $value) {
                    $data[] = [
                        'type'  => $type,
                        'no'    => -($index + 1),
                        'value' => '-' . $type . '-' . $value,
                    ];
                }
            }
        }

        DB::table('size_temas')->truncate();
        DB::table('size_temas')->insert($data);
    }
}
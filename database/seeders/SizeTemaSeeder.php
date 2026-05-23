<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeTemaSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['top', 'bottom', 'right', 'left', 'w'];

        $values = [
            "1","1.5","2","2.5","3","3.5","4","5","6","7","8","9","10","11","12",
            "14","16","20","24","28","32","36","40","44","48","52","56","60","64",
            "72","80","96","112","128","144","160","176","192","200","224","240",
            "256","288","320","360","384","400","448","512"
        ];

        $negativeValues = ["1","1.5","2","2.5","3","3.5","4","5","6","7","8"];

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
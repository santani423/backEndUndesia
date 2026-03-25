<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function index()
    {
        $data = [
            'message' => 'Demo API works',
            'demos' => [
                'website' => [
                    [
                        'title' => 'Wedding Theme',
                        'description' => 'Pastel gold elegant',
                        'category' => 'Pernikahan',
                        'thumbnail' => '/placeholder-wedding.jpg'
                    ],
                    [
                        'title' => 'Khitanan Theme',
                        'description' => 'Hijau islami',
                        'category' => 'Khitanan',
                        'thumbnail' => '/placeholder-khitanan.jpg'
                    ],
                    [
                        'title' => 'Birthday Theme',
                        'description' => 'Ceria balloons',
                        'category' => 'Ulang Tahun',
                        'thumbnail' => '/placeholder-birthday.jpg'
                    ]
                ],
                'video' => [
                    [
                        'title' => 'Wedding Video Invitation',
                        'description' => 'Animated Gold Theme',
                        'category' => 'Pernikahan',
                        'thumbnail' => '/placeholder-wedding-video.jpg',
                        'videoUrl' => '#'
                    ],
                    [
                        'title' => 'Khitanan Video Invitation',
                        'description' => 'Islamic Green Theme',
                        'category' => 'Khitanan',
                        'thumbnail' => '/placeholder-khitanan-video.jpg',
                        'videoUrl' => '#'
                    ],
                    [
                        'title' => 'Birthday Video Invitation',
                        'description' => 'Colorful Celebration',
                        'category' => 'Ulang Tahun',
                        'thumbnail' => '/placeholder-birthday-video.jpg',
                        'videoUrl' => '#'
                    ]
                ]
            ]
        ];

        return response()->json($data);
    }

    public function paket()
    {
        $paket = Paket::all();
        $newData = $paket->map(function ($item) {
            return [
                'id' => $item->id_paket,
                'nama_paket' => $item->nama_paket,
                'harga' => $item->harga_paket,
                'features' => [
                    [
                        'name' => 'Nama Fitur',
                        'description' => $item->import_datatamu
                    ]
                ],
            ];
        });
        $data = [
            'message' => 'Daftar Paket Undangan',
            'paket'   => $newData,
        ];

        return response()->json($data);
    }
}

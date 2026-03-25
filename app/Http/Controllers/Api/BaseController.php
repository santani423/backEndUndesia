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
                'harga_paket' => $item->harga_paket,
                'features' => [
                    [
                        'name' => $item->id_paket == 1 ? 'Hanya 1 Tema' : 'Bebas Pilih Tema',
                        'is_available' => 1
                    ],
                    [
                        'name' => 'Edit Tanpa Batas',
                        'is_available' => 1
                    ],
                    [
                        'name' => 'Kirim Undangan',
                        'is_available' => $item->kirim_whatsapp
                    ],
                    [
                        'name' => 'Import Data Tamu',
                        'is_available' => $item->import_datatamu
                    ],
                    [
                        'name' => 'Buku Tamu',
                        'is_available' => $item->buku_tamu
                    ],
                    [
                        'name' => 'Amplop Digital',
                        'is_available' => $item->kirim_hadiah
                    ],
                    [
                        'name' => 'Galeri Foto',
                        'is_available' => 1
                    ],
                    [
                        'name' => 'Background Music',
                        'is_available' => 1
                    ],
                    [
                        'name' => 'Love Story',
                        'is_available' => 1
                    ],
                    [
                        'name' => 'Countdown',
                        'is_available' => 1
                    ],
                    [
                        'name' => 'Rsvp',
                        'is_available' => 1
                    ],
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

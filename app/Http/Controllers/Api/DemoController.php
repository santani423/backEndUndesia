<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Demo",
 *     description="Demo API endpoints"
 * )
 */
class DemoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/demo",
     *     tags={"Demo"},
     *     summary="Get demo data",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
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
}

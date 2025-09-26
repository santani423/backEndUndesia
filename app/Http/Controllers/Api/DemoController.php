<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Undesia API Documentation",
 *     description="API documentation for Undesia project",
 *     @OA\Contact(
 *         email="support@undesia.com"
 *     )
 * )
 *
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
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Demo API works"),
     *             @OA\Property(
     *                 property="demos",
     *                 type="object",
     *                 @OA\Property(
     *                     property="website",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="title", type="string", example="Wedding Theme"),
     *                         @OA\Property(property="description", type="string", example="Pastel gold elegant"),
     *                         @OA\Property(property="category", type="string", example="Pernikahan"),
     *                         @OA\Property(property="thumbnail", type="string", example="/placeholder-wedding.jpg")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="video",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="title", type="string", example="Wedding Video Invitation"),
     *                         @OA\Property(property="description", type="string", example="Animated Gold Theme"),
     *                         @OA\Property(property="category", type="string", example="Pernikahan"),
     *                         @OA\Property(property="thumbnail", type="string", example="/placeholder-wedding-video.jpg"),
     *                         @OA\Property(property="videoUrl", type="string", example="#")
     *                     )
     *                 )
     *             )
     *         )
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

    /**
     * @OA\Get(
     *     path="/api/testimonials",
     *     tags={"Demo"},
     *     summary="Get list of testimonials",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="List of testimonials"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", example="Rina & Fajar"),
     *                     @OA\Property(property="eventType", type="string", example="Wedding"),
     *                     @OA\Property(property="text", type="string", example="UNDESIA membuat pernikahan kami terasa lebih eksklusif."),
     *                     @OA\Property(property="avatar", type="string", example="/placeholder-avatar1.jpg")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function testimonials()
    {
        $testimonials = [
            [
                'name' => 'Rina2 & Fajar',
                'eventType' => 'Wedding',
                'text' => 'UNDESIA membuat pernikahan kami terasa lebih eksklusif. Semua tamu mudah mengakses undangan digital kami.',
                'avatar' => '/placeholder-avatar1.jpg'
            ],
            [
                'name' => 'Sari & Ahmad',
                'eventType' => 'Khitanan',
                'text' => 'Undangan video animasi untuk khitanan anak kami sangat berkesan. Keluarga yang jauh bisa ikut merasakan momen bahagia ini.',
                'avatar' => '/placeholder-avatar2.jpg'
            ],
            [
                'name' => 'Maya & Budi',
                'eventType' => 'Birthday',
                'text' => 'Fitur QRIS dan buku tamu digital sangat memudahkan acara ulang tahun putri kami. Terima kasih UNDESIA!',
                'avatar' => '/placeholder-avatar3.jpg'
            ],
            [
                'name' => 'Dewi & Rizki',
                'eventType' => 'Wedding',
                'text' => 'Desain yang elegan dan fitur lengkap membuat undangan pernikahan kami terlihat profesional dan mudah digunakan.',
                'avatar' => '/placeholder-avatar4.jpg'
            ],
            [
                'name' => 'Amanda & Leo',
                'eventType' => 'Wedding',
                'text' => 'Desain yang elegan dan fitur lengkap membuat undangan pernikahan kami terlihat profesional dan mudah digunakan.',
                'avatar' => '/placeholder-avatar4.jpg'
            ],
        ];

        return response()->json([
            'message' => 'List of testimonials',
            'data' => $testimonials
        ]);
    }
}

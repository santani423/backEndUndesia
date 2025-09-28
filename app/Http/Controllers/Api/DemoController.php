<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use App\Models\Theme;
use App\Models\ThemeVideo;
use App\Models\TemaCategory;
use Illuminate\Http\Request;

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
    public function testimonials(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $testimonials = Testimoni::orderBy('id_testi', 'desc')->paginate($perPage);

        $data = $testimonials->map(function ($item) {
            return [
                'id_testi'      => $item->id_testi,
                'id_user'       => $item->id_user,
                'nama_lengkap'  => $item->nama_lengkap ?? 'Anonymous',
                'kota'          => $item->kota ?? 'Unknown',
                'provinsi'      => $item->provinsi ?? 'Unknown',
                'ulasan'        => $item->ulasan ?? 'No review',
                'status'        => $item->status ?? 'Pending',
                'avatar'        => '/placeholder-avatar' . rand(1, 4) . '.jpg',
                'event_type'    => 'Wedding',
            ];
        });

        return response()->json([
            'message' => 'List of testimonials',
            'current_page' => $testimonials->currentPage(),
            'per_page' => $testimonials->perPage(),
            'total' => $testimonials->total(),
            'last_page' => $testimonials->lastPage(),
            'data' => $data,
        ]);
    }

    public function themes(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $categoryId = $request->get('category_id');

        $query = Theme::with('category')->orderBy('id', 'desc');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $themes = $query->paginate($perPage);

        return response()->json([
            'message' => 'List of themes',
            'current_page' => $themes->currentPage(),
            'per_page' => $themes->perPage(),
            'total' => $themes->total(),
            'last_page' => $themes->lastPage(),
            'data' => $themes->items(),
        ]);
    }



    public function themeVideos(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $categoryId = $request->get('category_id');

        $query = ThemeVideo::with('category') // load theme + category
            ->orderBy('id_theme', 'desc');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $videos = $query->paginate($perPage);

        return response()->json([
            'message' => 'List of theme videos',
            'current_page' => $videos->currentPage(),
            'per_page' => $videos->perPage(),
            'total' => $videos->total(),
            'last_page' => $videos->lastPage(),
            'data' => $videos->items(),
        ]);
    }



    public function categories(Request $request)
    {
        $categories = TemaCategory::getAllCategories();

        return response()->json([
            'message' => 'List of categories',
            'data' => $categories,
        ]);
    }
}

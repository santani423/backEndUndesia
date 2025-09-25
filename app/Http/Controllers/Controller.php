<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * @OA\Get(
     *     path="/api/demo",
     *     operationId="getDemoData",
     *     tags={"Demo"},
     *     summary="Get demo data",
     *     description="Returns demo website and video templates",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="demos",
     *                 type="object",
     *                 @OA\Property(
     *                     property="website",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="description", type="string"),
     *                         @OA\Property(property="category", type="string"),
     *                         @OA\Property(property="thumbnail", type="string")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="video",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="description", type="string"),
     *                         @OA\Property(property="category", type="string"),
     *                         @OA\Property(property="thumbnail", type="string"),
     *                         @OA\Property(property="videoUrl", type="string")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
}

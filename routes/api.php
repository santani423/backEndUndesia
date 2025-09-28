<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DemoController;

Route::get('/demo', [DemoController::class, 'index']);

Route::get('/testimonials', [DemoController::class, 'testimonials']);
Route::get('/themes', [DemoController::class, 'themes']);
Route::get('/themeVideos', [DemoController::class, 'themeVideos']);



// http://127.0.0.1:8000/api/documentation#/Demo
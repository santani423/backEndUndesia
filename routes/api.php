<?php

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DemoController;
use App\Http\Controllers\SizeTemaController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\Api\DomainController;

Route::get('/demo', [DemoController::class, 'index']);
Route::get('/size', [SizeTemaController::class, 'index']);
Route::get('/brackPoin', [SizeTemaController::class, 'brackPoin']);
Route::get('/tema', [TemaController::class, 'index']);
Route::post('/tema', [TemaController::class, 'store']);
Route::get('/tema/{id}', [TemaController::class, 'show']);
Route::put('/tema/{code}/full', [TemaController::class, 'updateByCode']);
Route::delete('/tema/{code}', [TemaController::class, 'destroy']);
Route::get('/domains', [DomainController::class, 'index']);
Route::get('/domains/{id}', [DomainController::class, 'show']);
Route::get('/komentar', [DomainController::class, 'komentarAll']);
Route::post('/komentar', [DomainController::class, 'komentar']);
Route::get('/tamu/{id}/{slug}', [DomainController::class, 'tamu']);
Route::put('/tema', [TemaController::class, 'edit']);
Route::put('/tema/{id}', [TemaController::class, 'update']);

Route::put('/tamu', [DomainController::class, 'rsv  pAdd']);

Route::get('/testimonials', [DemoController::class, 'testimonials']);
Route::get('/themes', [DemoController::class, 'themes']);
Route::get('/themeVideos', [DemoController::class, 'themeVideos']);
Route::get('/categories', [DemoController::class, 'categories']);

Route::get('/template', [DemoController::class, 'FunctionName']);
Route::get('/paket', [BaseController::class, 'paket']);



// http://127.0.0.1:8000/api/documentation#/Demo
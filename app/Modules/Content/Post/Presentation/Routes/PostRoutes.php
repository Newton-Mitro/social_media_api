<?php

use App\Modules\Auth\Presentation\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Auth\Presentation\Middlewares\RequestUserMiddleware;
use App\Modules\Content\Post\Presentation\Controllers\PostController;
use App\Modules\Content\Post\Presentation\Controllers\PostControllerV2;
use Illuminate\Support\Facades\Route;


Route::middleware(RequestUserMiddleware::class)->group(function (): void {
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
});

Route::middleware(JwtAccessTokenMiddleware::class)->group(function (): void {
    Route::post('/posts', [PostController::class, 'store']);
    Route::post('/posts/update/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::post('/posts/{id}/like', [PostController::class, 'like']);
    Route::delete('/posts/{id}/like', [PostController::class, 'unlike']);
    Route::post('/posts/{id}/share', [PostController::class, 'share']);
});

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('v2')->group(function () {
    Route::post('/posts', [PostControllerV2::class, 'store']);
    Route::put('/posts/{id}', [PostControllerV2::class, 'update']);
});

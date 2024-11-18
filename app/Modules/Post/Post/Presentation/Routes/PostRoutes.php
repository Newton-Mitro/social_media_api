<?php


use App\Modules\Auth\Presentation\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Auth\Presentation\Middlewares\RequestUserMiddleware;
use App\Modules\Post\Presentation\Controllers\FetchPostsController;
use App\Modules\Post\Presentation\Controllers\PostController;
use App\Modules\Post\Presentation\Controllers\PrivacyController;
use Illuminate\Support\Facades\Route;


Route::get('/privacies', [PrivacyController::class, 'index']);

Route::middleware(RequestUserMiddleware::class)->group(function (): void {
    Route::get('/posts', FetchPostsController::class);
});

Route::middleware(JwtAccessTokenMiddleware::class)->group(function (): void {
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::post('/posts/{id}/like', [PostController::class, 'like']);
    Route::delete('/posts/{id}/like', [PostController::class, 'unlike']);
    Route::post('/posts/{id}/share', [PostController::class, 'share']);
});

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('v2')->group(function () {
    Route::post('/posts', [PostController::class, 'store_v2']);
    Route::put('/posts/{id}', [PostController::class, 'update_v2']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy_v2']);
});

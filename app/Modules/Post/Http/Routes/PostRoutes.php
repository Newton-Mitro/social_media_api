<?php


use App\Modules\Auth\Authentication\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Auth\Authentication\Middlewares\RequestUserMiddleware;
use App\Modules\Post\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;



Route::get('/privacies', [PostController::class, 'privacies']);

Route::middleware(RequestUserMiddleware::class)->group(function (): void {
    Route::get('/posts', [PostController::class, 'index']);
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

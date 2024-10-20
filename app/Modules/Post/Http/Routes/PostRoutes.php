<?php


use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Authentication\Middlewares\JwtAccessTokenMiddleware;

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('posts')->group(function (): void {
    // Route::post('create', CreatePostController::class)->name('posts.create');
});

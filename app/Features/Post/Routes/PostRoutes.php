<?php

use Illuminate\Support\Facades\Route;
use App\Features\Post\Controllers\GetPostController;
use App\Features\Post\Controllers\CreatePostController;
use App\Features\Post\Controllers\UpdatePostPrivacyController;
use App\Features\Auth\Authentication\Middlewares\JwtAccessTokenMiddleware;
use App\Features\Post\Controllers\RemovePostController;
use App\Features\Post\Controllers\UpdatePostController;

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('posts')->group(function (): void {
    Route::post('create', CreatePostController::class)->name('posts.create');
    Route::post('update', UpdatePostController::class)->name('posts.update');
    Route::post('remove', RemovePostController::class)->name('posts.remove');
    Route::get('user/{user_id}', GetPostController::class)->name('posts.userPosts');
    Route::post('update_post_privacy', UpdatePostPrivacyController::class)->name('posts.updatePostPrivacy');
});

Route::get('posts/all/{user_id}', [GetPostController::class,'get_all_posts'])->name('posts.allPosts');

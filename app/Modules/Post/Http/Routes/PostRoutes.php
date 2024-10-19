<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Post\Controllers\GetPostController;
use App\Modules\Post\Controllers\CreatePostController;
use App\Modules\Post\Controllers\UpdatePostPrivacyController;
use App\Modules\Auth\Authentication\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Post\Controllers\RemovePostController;
use App\Modules\Post\Controllers\UpdatePostController;

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('posts')->group(function (): void {
    Route::post('create', CreatePostController::class)->name('posts.create');
    Route::post('update', UpdatePostController::class)->name('posts.update');
    Route::post('remove', RemovePostController::class)->name('posts.remove');
    Route::get('user/{user_id}', GetPostController::class)->name('posts.userPosts');
    Route::post('update_post_privacy', UpdatePostPrivacyController::class)->name('posts.updatePostPrivacy');
});

Route::get('posts/all/{user_id}', [GetPostController::class, 'get_all_posts'])->name('posts.allPosts');

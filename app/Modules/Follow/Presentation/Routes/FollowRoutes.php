<?php

use App\Modules\Auth\Presentation\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Follow\Presentation\Controllers\FollowController;
use Illuminate\Support\Facades\Route;


Route::middleware(JwtAccessTokenMiddleware::class)->group(function () {
    Route::post('/follow', [FollowController::class, 'follow']);
    Route::delete('/unfollow/{followingId}', [FollowController::class, 'unfollow']);
    Route::get('/following/{userId}', [FollowController::class, 'getFollowing']);
    Route::get('/followers/{userId}', [FollowController::class, 'getFollowers']);
});

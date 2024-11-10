<?php

use App\Modules\Auth\Authentication\Presentation\Controllers\FetchUserProfileController;
use App\Modules\Auth\Authentication\Presentation\Controllers\UpdateCoverPictureController;
use App\Modules\Auth\Authentication\Presentation\Controllers\UpdateProfilePictureController;
use App\Modules\Auth\Authentication\Presentation\Middlewares\JwtAccessTokenMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware(JwtAccessTokenMiddleware::class)->prefix('user')->group(function (): void {
    Route::post('profile/picture/update', UpdateProfilePictureController::class)->name('user.profile-picture-update');
    Route::post('cover/picture/update', UpdateCoverPictureController::class)->name('user.cover-picture-update');
});

Route::get('user/profile/{userId}', FetchUserProfileController::class);

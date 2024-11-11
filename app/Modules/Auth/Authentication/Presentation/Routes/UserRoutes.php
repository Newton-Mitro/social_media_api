<?php

use App\Modules\Auth\Authentication\Presentation\Controllers\FetchUserProfileController;
use App\Modules\Auth\Authentication\Presentation\Controllers\ChangeCoverPhotoController;
use App\Modules\Auth\Authentication\Presentation\Controllers\UpdateProfilePictureController;
use App\Modules\Auth\Authentication\Presentation\Middlewares\JwtAccessTokenMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware(JwtAccessTokenMiddleware::class)->group(function (): void {
    Route::post('users/update/profile-picture', UpdateProfilePictureController::class)->name('users.update_profile_picture');
    Route::post('users/update/cover-photo', ChangeCoverPhotoController::class)->name('users.update_cover_photo');
});

Route::get('users/profile/{user_id}', FetchUserProfileController::class)->name('users.fetch_profile');

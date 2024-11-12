<?php


use Illuminate\Support\Facades\Route;
use App\Modules\Profile\Presentation\Controllers\ChangeCoverPhotoController;
use App\Modules\Profile\Presentation\Controllers\FetchUserProfileController;
use App\Modules\Profile\Presentation\Controllers\UpdateProfilePictureController;
use App\Modules\Auth\Presentation\Middlewares\RequestUserMiddleware;
use App\Modules\Auth\Presentation\Middlewares\JwtAccessTokenMiddleware;



Route::middleware(JwtAccessTokenMiddleware::class)->group(function (): void {
    Route::post('users/update/profile-picture', UpdateProfilePictureController::class)->name('users.update_profile_picture');
    Route::post('users/update/cover-photo', ChangeCoverPhotoController::class)->name('users.update_cover_photo');
});



Route::middleware(RequestUserMiddleware::class)->group(function (): void {
    Route::get('users/profile/{user_id}', FetchUserProfileController::class)->name('users.fetch_profile');
});

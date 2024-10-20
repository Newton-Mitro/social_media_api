<?php


use App\Modules\Auth\Authentication\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Auth\User\Controllers\UpdateCoverPictureController;
use App\Modules\Auth\User\Controllers\UpdateProfilePictureController;
use Illuminate\Support\Facades\Route;


Route::middleware(JwtAccessTokenMiddleware::class)->prefix('user')->group(function (): void {
    Route::post('profile/picture/update', UpdateProfilePictureController::class)->name('user.profile-picture-update');
    Route::post('cover/picture/update', UpdateCoverPictureController::class)->name('user.cover-picture-update');
});

<?php

use App\Modules\Auth\Authentication\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\StorageFile\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;




Route::middleware(JwtAccessTokenMiddleware::class)->group(function () {
    Route::post('/upload', [FileUploadController::class, 'upload']);
    Route::post('/link-info', [FileUploadController::class, 'getLinkInfo']);
});

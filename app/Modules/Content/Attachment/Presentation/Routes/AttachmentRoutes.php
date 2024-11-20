<?php

use App\Modules\Auth\Presentation\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Auth\Presentation\Middlewares\RequestUserMiddleware;
use App\Modules\Content\Attachment\Presentation\Controllers\AttachmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(RequestUserMiddleware::class)->group(function (): void {
    Route::get('attachments', [AttachmentController::class, 'index']);
    Route::get('attachments/{id}', [AttachmentController::class, 'show']);
});

Route::middleware(JwtAccessTokenMiddleware::class)->group(function (): void {
    Route::post('attachments', [AttachmentController::class, 'store']);
    Route::put('attachments/{id}', [AttachmentController::class, 'update']);
    Route::delete('attachments/{id}', [AttachmentController::class, 'destroy']);
});

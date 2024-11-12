<?php

use App\Modules\Auth\Presentation\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Friend\Presentation\Controllers\FriendRequestController;
use Illuminate\Support\Facades\Route;


Route::middleware(JwtAccessTokenMiddleware::class)->group(function () {
    Route::post('/friend-request/send/{receiverId}', [FriendRequestController::class, 'sendRequest']);
    Route::post('/friend-request/accept/{requestId}', [FriendRequestController::class, 'acceptRequest']);
    Route::post('/friend-request/reject/{requestId}', [FriendRequestController::class, 'rejectRequest']);
    Route::get('/friend-request/status/{userId}/{otherUserId}', [FriendRequestController::class, 'checkStatus']);
    Route::get('/friend-request/pending-count', [FriendRequestController::class, 'pendingRequestCount']);
    Route::get('/friends/{userId}', [FriendRequestController::class, 'friendsList']);
});

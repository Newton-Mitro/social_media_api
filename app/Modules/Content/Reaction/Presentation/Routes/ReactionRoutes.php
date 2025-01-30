<?php

use App\Modules\Content\Reaction\Presentation\Controllers\ReactionController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    Route::post('posts/reactions', [ReactionController::class, 'store']); 
    Route::delete('posts/reactions', [ReactionController::class, 'destroy']); 
});

<?php

use App\Modules\Search\Http\Controllers\GlobalSearchController;
use App\Modules\Search\Http\Controllers\UserAndGroupSearchController;
use Illuminate\Support\Facades\Route;





Route::get('/global/search', GlobalSearchController::class)->name('search.global');
Route::get('/user-and-group/search', UserAndGroupSearchController::class)->name('search.user_and_group');

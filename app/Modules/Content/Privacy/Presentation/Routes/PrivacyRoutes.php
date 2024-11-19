<?php

use App\Modules\Content\Privacy\Presentation\Controllers\PrivacyController;
use Illuminate\Support\Facades\Route;



Route::get('/privacies', [PrivacyController::class, 'index']);

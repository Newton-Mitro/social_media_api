<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Authentication\Presentation\Controllers\LoginController;
use App\Modules\Auth\Authentication\Presentation\Controllers\LogoutController;
use App\Modules\Auth\Authentication\Presentation\Controllers\AuthUserController;
use App\Modules\Auth\Authentication\Presentation\Controllers\RefreshTokenController;
use App\Modules\Auth\Authentication\Presentation\Controllers\RegistrationController;
use App\Modules\Auth\Authentication\Presentation\Controllers\ResetPasswordController;
use App\Modules\Auth\Authentication\Presentation\Controllers\ForgotPasswordController;
use App\Modules\Auth\Authentication\Presentation\Controllers\PasswordChangeController;
use App\Modules\Auth\Authentication\Presentation\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Auth\Authentication\Presentation\Middlewares\JwtRefreshTokenMiddleware;
use App\Modules\Auth\Authentication\Presentation\Controllers\ResendForgotPasswordController;
use App\Modules\Auth\Authentication\Presentation\Controllers\VerifyForgotPasswordOTPController;
use App\Modules\Auth\Authentication\Presentation\Controllers\ResendAccountVerificationOtpController;
use App\Modules\Auth\Authentication\Presentation\Controllers\VerifyAccountVerificationOtpController;


Route::middleware('guest')->prefix('auth')->group(function (): void {
    Route::post('register', RegistrationController::class)->name('auth.register');
    Route::post('login', LoginController::class)->name('auth.login');
    Route::post('forgot-password', ForgotPasswordController::class)->name('auth.forgotPassword');
    Route::post('verify-forgot-password-otp', VerifyForgotPasswordOTPController::class)->name('auth.verifyForgotPasswordOTP');
    Route::post('password-change', PasswordChangeController::class)->name('auth.password-change');
    Route::post('resend-forgot-password-otp', ResendForgotPasswordController::class)->name('auth.resendForgotPasswordOTP');
    Route::post('reset-password', ResetPasswordController::class)->name('auth.resentPassword');
});

Route::middleware(JwtRefreshTokenMiddleware::class)->prefix('auth')->group(function (): void {
    Route::get('refresh', RefreshTokenController::class)->name('auth.refresh');
});

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('account')->group(function (): void {
    Route::post('email/verify', VerifyAccountVerificationOtpController::class)->name('account.verify');
    Route::post('email/resend', ResendAccountVerificationOtpController::class)->name('account.resend');
});

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('auth')->group(function (): void {
    Route::get('user', AuthUserController::class)->name('auth.user');
    Route::get('logout', LogoutController::class)->name('auth.logout');
    Route::post('password-change', PasswordChangeController::class)->name('auth.password-change');
});

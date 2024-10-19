<?php

use Illuminate\Support\Facades\Route;
use App\Features\Auth\Authentication\Controllers\LoginController;
use App\Features\Auth\Authentication\Controllers\LogoutController;
use App\Features\Auth\Authentication\Controllers\AuthUserController;
use App\Features\Auth\Authentication\Controllers\GetPrivacyController;
use App\Features\Auth\Authentication\Controllers\RefreshTokenController;
use App\Features\Auth\Authentication\Controllers\RegistrationController;
use App\Features\Auth\Authentication\Controllers\ResetPasswordController;
use App\Features\Auth\Authentication\Controllers\ForgotPasswordController;
use App\Features\Auth\Authentication\Controllers\PasswordChangeController;
use App\Features\Auth\Authentication\Middlewares\JwtAccessTokenMiddleware;
use App\Features\Auth\Authentication\Middlewares\JwtRefreshTokenMiddleware;
use App\Features\Auth\Authentication\Controllers\ResendForgotPasswordController;
use App\Features\Auth\Authentication\Controllers\VerifyForgotPasswordOTPController;
use App\Features\Auth\Authentication\Controllers\ResendAccountVerificationOtpController;
use App\Features\Auth\Authentication\Controllers\VerifyAccountVerificationOtpController;

Route::middleware('guest')->prefix('auth')->group(function (): void {
    Route::post('register', RegistrationController::class)->name('auth.register');
    Route::post('login', LoginController::class)->name('auth.login');
    Route::post('forgot-password', ForgotPasswordController::class)->name('auth.forgotPassword');
    Route::post('verify-forgot-password-otp', VerifyForgotPasswordOTPController::class)->name('auth.verifyForgotPasswordOTP');
    Route::post('password-change', PasswordChangeController::class)->name('auth.password-change');
    Route::post('resend-forgot-password-otp', ResendForgotPasswordController::class)->name('auth.resendForgotPasswordOTP');
    Route::post('reset-password', ResetPasswordController::class)->name('auth.resentPassword');
    Route::get('get-privacy', GetPrivacyController::class)->name('auth.getPrivacy');
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

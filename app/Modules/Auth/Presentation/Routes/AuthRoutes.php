<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Presentation\Controllers\LoginController;
use App\Modules\Auth\Presentation\Controllers\LogoutController;
use App\Modules\Auth\Presentation\Controllers\AuthUserController;
use App\Modules\Auth\Presentation\Controllers\FetchRefreshTokenController;
use App\Modules\Auth\Presentation\Controllers\RegistrationController;
use App\Modules\Auth\Presentation\Controllers\ResetPasswordController;
use App\Modules\Auth\Presentation\Controllers\ForgotPasswordController;
use App\Modules\Auth\Presentation\Controllers\ChangePasswordController;
use App\Modules\Auth\Presentation\Middlewares\JwtAccessTokenMiddleware;
use App\Modules\Auth\Presentation\Middlewares\JwtRefreshTokenMiddleware;
use App\Modules\Auth\Presentation\Controllers\ResendForgotPasswordController;
use App\Modules\Auth\Presentation\Controllers\ForgotPasswordOtpVerifyController;
use App\Modules\Auth\Presentation\Controllers\ResendAccountVerificationOtpController;
use App\Modules\Auth\Presentation\Controllers\AccountOtpVerifyController;


Route::middleware('guest')->prefix('auth')->group(function (): void {
    Route::post('register', RegistrationController::class)->name('auth.register');
    Route::post('login', LoginController::class)->name('auth.login');
    Route::post('forgot-password', ForgotPasswordController::class)->name('auth.forgot_password');
    Route::post('forgot-password-otp-verify', ForgotPasswordOtpVerifyController::class)->name('auth.forgot_password_otp_verify');
    Route::post('change-password', ChangePasswordController::class)->name('auth.change_password');
    Route::post('resend-forgot-password-otp', ResendForgotPasswordController::class)->name('auth.resend_forgot_password_otp');
    Route::post('reset-password', ResetPasswordController::class)->name('auth.reset_password');
});

Route::middleware(JwtRefreshTokenMiddleware::class)->prefix('auth')->group(function (): void {
    Route::get('refresh', FetchRefreshTokenController::class)->name('auth.fetch_refresh_token');
});

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('account')->group(function (): void {
    Route::post('email/verify', AccountOtpVerifyController::class)->name('account.account_otp_verify');
    Route::post('email/resend', ResendAccountVerificationOtpController::class)->name('account.resend_account_verification_opt');
});

Route::middleware(JwtAccessTokenMiddleware::class)->prefix('auth')->group(function (): void {
    Route::get('user', AuthUserController::class)->name('auth.fetch_auth_user');
    Route::get('logout', LogoutController::class)->name('auth.logout');
    Route::post('change-password', ChangePasswordController::class)->name('auth.change_password');
});

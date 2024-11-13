<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\UseCases\ForgotPasswordUseCase;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpMapper;
use App\Modules\Auth\Presentation\Requests\ForgotPasswordOTPRequest;

class ResendForgotPasswordController extends Controller
{
    public function __construct(protected ForgotPasswordUseCase $forgotPasswordUseCase) {}

    public function __invoke(ForgotPasswordOTPRequest $request)
    {
        $userOtp = $this->forgotPasswordUseCase->handle(
            email: $request->data()->email
        );

        return response()->json([
            'data' => UserOtpMapper::toForgotPasswordOTPDTO($userOtp),
            'message' => 'OTP has been sent to your email.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\ForgotPasswordUseCase;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserOtpMapper;
use App\Modules\Auth\Authentication\Presentation\Requests\ForgotPasswordOTPRequest;

class ResendForgotPasswordController extends Controller
{
    public function __construct(protected ForgotPasswordUseCase $forgotPasswordUseCase) {}

    public function __invoke(ForgotPasswordOTPRequest $request)
    {
        $userOtp = $this->forgotPasswordUseCase->handle(
            email: $request->data()->email
        );

        return response()->json([
            'data' => UserOtpMapper::toForgotPasswordOTPResource($userOtp),
            'message' => 'OTP has been sent to your email.',
            'errors' => null,
        ]);
    }
}

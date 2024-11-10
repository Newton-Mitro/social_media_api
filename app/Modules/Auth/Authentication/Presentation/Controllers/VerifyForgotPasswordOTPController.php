<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\VerifyForgotPasswordOTPCommandHandler;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserOtpMapper;
use App\Modules\Auth\Authentication\Presentation\Requests\VerifyForgotPasswordOTPRequest;

class VerifyForgotPasswordOTPController extends Controller
{
    public function __construct(protected VerifyForgotPasswordOTPCommandHandler $verifyForgotPasswordOTPCommandHandler) {}

    public function __invoke(VerifyForgotPasswordOTPRequest $request)
    {
        $userOtp = $this->verifyForgotPasswordOTPCommandHandler->handle(
            email: $request->data()->email,
            otp: $request->data()->otp,
        );

        return response()->json([
            'data' => UserOtpMapper::toVerifyForgotPasswordOTPResource($userOtp),
            'message' => 'OTP verified successfully.',
            'errors' => null,
        ]);
    }
}

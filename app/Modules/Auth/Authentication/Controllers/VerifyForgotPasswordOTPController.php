<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\OTP\Mappers\UserOtpMapper;
use App\Modules\Auth\OTP\Requests\VerifyForgotPasswordOTPRequest;
use App\Modules\Auth\OTP\UseCases\VerifyForgotPasswordOTPCommandHandler;

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

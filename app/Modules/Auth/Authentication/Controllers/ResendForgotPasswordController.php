<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Requests\ForgotPasswordOTPRequest;
use App\Modules\Auth\Authentication\UseCases\ForgotPasswordOTPCommandHandler;
use App\Modules\Auth\OTP\Mappers\UserOtpMapper;

class ResendForgotPasswordController extends Controller
{
    public function __construct(protected ForgotPasswordOTPCommandHandler $forgotPasswordOTPCommandHandler) {}

    public function __invoke(ForgotPasswordOTPRequest $request)
    {
        $userOtp = $this->forgotPasswordOTPCommandHandler->handle(
            email: $request->data()->email
        );

        return response()->json([
            'data' => UserOtpMapper::toForgotPasswordOTPResource($userOtp),
            'message' => 'OTP has been sent to your email.',
            'errors' => null,
        ]);
    }
}

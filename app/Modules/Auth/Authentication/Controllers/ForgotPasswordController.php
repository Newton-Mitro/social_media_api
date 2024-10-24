<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Requests\ForgotPasswordOTPRequest;
use App\Modules\Auth\Authentication\UseCases\ForgotPasswordOTPCommandHandler;
use App\Modules\Auth\OTP\Mappers\UserOtpMapper;

class ForgotPasswordController extends Controller
{
    public function __construct(protected readonly ForgotPasswordOTPCommandHandler $forgotPasswordOTPCommandHandler) {}

    public function __invoke(ForgotPasswordOTPRequest $request)
    {
        $userOTP = $this->forgotPasswordOTPCommandHandler->handle($request->email);

        return response()->json([
            'data' => UserOtpMapper::toForgotPasswordOTPResource($userOTP),
            'message' => 'OTP has been sent to your email.',
            'errors' => null,
        ]);
    }
}

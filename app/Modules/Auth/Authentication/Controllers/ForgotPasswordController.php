<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\OTP\Mappers\UserOtpMapper;
use App\Modules\Auth\Authentication\Requests\ForgotPasswordOTPRequest;
use App\Modules\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP\ForgotPasswordOTPCommand;

class ForgotPasswordController extends Controller
{
    public function __construct() {}

    public function __invoke(ForgotPasswordOTPRequest $request)
    {
        $userOtp = $this->commandBus->dispatch(
            new ForgotPasswordOTPCommand(
                email: $request->data()->email
            ),
        );
        return response()->json([
            'data' => UserOtpMapper::toForgotPasswordOTPResource($userOtp),
            'message' => 'OTP has been sent to your email.',
            'errors' => null,
        ]);
    }
}

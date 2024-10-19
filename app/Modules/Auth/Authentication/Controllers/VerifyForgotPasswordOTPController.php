<?php

namespace App\Features\Auth\Authentication\Controllers;

use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\OTP\Mappers\UserOtpMapper;
use App\Features\Auth\OTP\Requests\VerifyForgotPasswordOTPRequest;
use App\Features\Auth\OTP\UseCases\Commands\VerifyForgotPasswordOTP\VerifyForgotPasswordOTPCommand;

class VerifyForgotPasswordOTPController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {
    }

    public function __invoke(VerifyForgotPasswordOTPRequest $request)
    {
        $userOtp = $this->commandBus->dispatch(
            new VerifyForgotPasswordOTPCommand(
                email: $request->data()->email,
                otp: $request->data()->otp,
            ),
        );

        return response()->json([
            'data' => UserOtpMapper::toVerifyForgotPasswordOTPResource($userOtp),
            'message' => 'OTP verified successfully.',
            'errors' => null,
        ]);
    }
}

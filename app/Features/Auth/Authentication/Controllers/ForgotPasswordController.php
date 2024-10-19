<?php

namespace App\Features\Auth\Authentication\Controllers;

use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\OTP\Mappers\UserOtpMapper;
use App\Features\Auth\Authentication\Requests\ForgotPasswordOTPRequest;
use App\Features\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP\ForgotPasswordOTPCommand;

class ForgotPasswordController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {
    }

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
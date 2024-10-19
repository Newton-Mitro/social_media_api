<?php

namespace App\Features\Auth\Authentication\Controllers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\Authentication\UseCases\Commands\ReSendEmailVerifyingOTP\ReSendEmailVerifyingOTPCommand;
use Illuminate\Http\Request;

class ResendAccountVerificationOtpController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {}

    public function __invoke(Request $request)
    {
        request()->user;

        $this->commandBus->dispatch(
            new ReSendEmailVerifyingOTPCommand(
                request()->user['email'],
            ),
        );

        return response()->json([
            'data' => null,
            'message' => 'OTP has been sent successfully',
            'errors' => null,
        ]);
    }
}

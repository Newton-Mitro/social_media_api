<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Requests\VerifyAccountVerificationOtpRequest;
use App\Modules\Auth\Authentication\UseCases\Commands\VerifyEmailVerifyingOTP\VerifyEmailVerifyingOTPCommand;

class VerifyAccountVerificationOtpController extends Controller
{
    public function __construct() {}

    public function __invoke(VerifyAccountVerificationOtpRequest $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $request->path();
        $request->method();
        $request->query();

        $res = $this->commandBus->dispatch(
            new VerifyEmailVerifyingOTPCommand(
                device_name: $userAgent,
                device_ip: $ip,
                email: request()->user['email'],
                otp: $request->data()->otp
            ),
        );

        return response()->json([
            'data' => $res,
            'message' => 'Verification successfully completed.',
            'errors' => null,
        ]);
    }
}

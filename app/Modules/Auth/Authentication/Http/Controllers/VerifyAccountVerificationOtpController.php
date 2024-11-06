<?php

namespace App\Modules\Auth\Authentication\Http\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\VerifyEmailVerifyingOTPCommandHandler;
use App\Modules\Auth\Authentication\Http\Requests\VerifyAccountVerificationOtpRequest;

class VerifyAccountVerificationOtpController extends Controller
{
    public function __construct(protected VerifyEmailVerifyingOTPCommandHandler $verifyEmailVerifyingOTPCommandHandler) {}

    public function __invoke(VerifyAccountVerificationOtpRequest $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $request->path();
        $request->method();
        $request->query();

        $res = $this->verifyEmailVerifyingOTPCommandHandler->handle(
            deviceName: $userAgent,
            deviceIP: $ip,
            email: request()->user['email'],
            otp: $request->data()->otp
        );

        return response()->json([
            'data' => $res,
            'message' => 'Verification successfully completed.',
            'errors' => null,
        ]);
    }
}

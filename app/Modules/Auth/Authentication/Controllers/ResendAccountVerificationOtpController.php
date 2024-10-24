<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\UseCases\ReSendEmailVerifyingOTPCommandHandler;
use Illuminate\Http\Request;

class ResendAccountVerificationOtpController extends Controller
{
    public function __construct(protected ReSendEmailVerifyingOTPCommandHandler $reSendEmailVerifyingOTPCommandHandler) {}

    public function __invoke(Request $request)
    {
        request()->user;

        $this->reSendEmailVerifyingOTPCommandHandler->handle(
            request()->user['email'],
        );

        return response()->json([
            'data' => null,
            'message' => 'OTP has been sent successfully',
            'errors' => null,
        ]);
    }
}

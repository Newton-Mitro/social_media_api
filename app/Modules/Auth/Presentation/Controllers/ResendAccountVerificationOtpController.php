<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\UseCases\ReSendEmailVerifyingOTPUseCase;
use Illuminate\Http\Request;

class ResendAccountVerificationOtpController extends Controller
{
    public function __construct(protected ReSendEmailVerifyingOTPUseCase $reSendEmailVerifyingOTPUseCase) {}

    public function __invoke(Request $request)
    {
        request()->user;

        $this->reSendEmailVerifyingOTPUseCase->handle(
            request()->user['email'],
        );

        return response()->json([
            'data' => null,
            'message' => 'OTP has been sent successfully',
            'error' => null,
            'errors' => null,
        ]);
    }
}

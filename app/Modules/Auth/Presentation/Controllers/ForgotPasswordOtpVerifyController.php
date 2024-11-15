<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\UseCases\ForgotPasswordOtpVerifyUseCase;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpMapper;
use App\Modules\Auth\Presentation\Requests\ForgotPasswordOtpVerifyRequest;

class ForgotPasswordOtpVerifyController extends Controller
{
    public function __construct(protected ForgotPasswordOtpVerifyUseCase $forgotPasswordOtpVerifyUseCase) {}

    public function __invoke(ForgotPasswordOtpVerifyRequest $request)
    {
        $userOtp = $this->forgotPasswordOtpVerifyUseCase->handle(
            email: $request->input('email'),
            otp: $request->input('otp'),
        );

        return response()->json([
            'data' => $userOtp,
            'message' => 'OTP verified successfully.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

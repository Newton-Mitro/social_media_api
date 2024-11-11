<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\ForgotPasswordOtpVerifyUseCase;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserOtpMapper;
use App\Modules\Auth\Authentication\Presentation\Requests\ForgotPasswordOtpVerifyRequest;

class ForgotPasswordOtpVerifyController extends Controller
{
    public function __construct(protected ForgotPasswordOtpVerifyUseCase $forgotPasswordOtpVerifyUseCase) {}

    public function __invoke(ForgotPasswordOtpVerifyRequest $request)
    {
        $userOtp = $this->forgotPasswordOtpVerifyUseCase->handle(
            email: $request->data()->email,
            otp: $request->data()->otp,
        );

        return response()->json([
            'data' => UserOtpMapper::toVerifyForgotPasswordOTPResource($userOtp),
            'message' => 'OTP verified successfully.',
            'errors' => null,
        ]);
    }
}

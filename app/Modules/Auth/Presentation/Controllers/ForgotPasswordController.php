<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\UseCases\ForgotPasswordUseCase;
use App\Modules\Auth\Infrastructure\Mappers\UserOtpMapper;
use App\Modules\Auth\Presentation\Requests\ForgotPasswordOTPRequest;

class ForgotPasswordController extends Controller
{
    public function __construct(protected readonly ForgotPasswordUseCase $forgotPasswordUseCase) {}

    public function __invoke(ForgotPasswordOTPRequest $request)
    {
        $userOTP = $this->forgotPasswordUseCase->handle($request->email);

        return response()->json([
            'data' => UserOtpMapper::toForgotPasswordOTPResource($userOTP),
            'message' => 'OTP has been sent to your email.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\UseCases\ForgotPasswordUseCase;
use App\Modules\Auth\Presentation\Requests\ForgotPasswordOTPRequest;

class ForgotPasswordController extends Controller
{
    public function __construct(protected readonly ForgotPasswordUseCase $forgotPasswordUseCase) {}

    public function __invoke(ForgotPasswordOTPRequest $request)
    {
        $userOTP = $this->forgotPasswordUseCase->handle($request->input('email'));

        return response()->json([
            'data' => $userOTP,
            'message' => 'OTP has been sent to your email.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

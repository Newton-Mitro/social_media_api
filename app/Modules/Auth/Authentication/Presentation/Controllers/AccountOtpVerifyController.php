<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\AccountOtpVerifyUseCase;
use App\Modules\Auth\Authentication\Presentation\Requests\AccountOtpVerifyRequest;

class AccountOtpVerifyController extends Controller
{
    public function __construct(protected AccountOtpVerifyUseCase $accountOtpVerifyUseCase) {}

    public function __invoke(AccountOtpVerifyRequest $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $request->path();
        $request->method();
        $request->query();

        $res = $this->accountOtpVerifyUseCase->handle(
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

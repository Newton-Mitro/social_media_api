<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Requests\ResetPasswordRequest;
use App\Modules\Auth\Authentication\UseCases\Commands\ResetPassword\ResetPasswordCommandHandler;

class ResetPasswordController extends Controller
{
    public function __construct(protected ResetPasswordCommandHandler $resetPasswordCommandHandler) {}

    public function __invoke(ResetPasswordRequest $request)
    {

        $this->resetPasswordCommandHandler->handle(
            email: $request->data()->email,
            password: $request->data()->password,
            token: $request->data()->token
        );

        return response()->json([
            'data' => null,
            'message' => 'Password reset successfully.',
            'errors' => null,
        ]);
    }
}

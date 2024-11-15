<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\UseCases\ResetPasswordUseCase;
use App\Modules\Auth\Presentation\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function __construct(protected ResetPasswordUseCase $resetPasswordUseCase) {}

    public function __invoke(ResetPasswordRequest $request)
    {

        $this->resetPasswordUseCase->handle(
            email: $request->input('email'),
            password: $request->input('password'),
            token: $request->input('token')
        );

        return response()->json([
            'data' => null,
            'message' => 'Password reset successfully.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

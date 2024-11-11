<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\ResetPasswordUseCase;
use App\Modules\Auth\Authentication\Presentation\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function __construct(protected ResetPasswordUseCase $resetPasswordUseCase) {}

    public function __invoke(ResetPasswordRequest $request)
    {

        $this->resetPasswordUseCase->handle(
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

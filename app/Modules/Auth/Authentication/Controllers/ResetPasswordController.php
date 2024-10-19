<?php

namespace App\Features\Auth\Authentication\Controllers;

use App\Core\Bus\ICommandBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\Authentication\Requests\ResetPasswordRequest;
use App\Features\Auth\Authentication\UseCases\Commands\ResetPassword\ResetPasswordCommand;

class ResetPasswordController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus
    ) {
    }

    public function __invoke(ResetPasswordRequest $request)
    {

        $this->commandBus->dispatch(
            new ResetPasswordCommand(
                email: $request->data()->email,
                password: $request->data()->password,
                token: $request->data()->token
            ),
        );

        return response()->json([
            'data' => null,
            'message' => 'Password reset successfully.',
            'errors' => null,
        ]);
    }
}

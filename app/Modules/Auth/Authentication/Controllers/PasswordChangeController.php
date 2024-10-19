<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Requests\PasswordChangeRequest;
use App\Modules\Auth\Authentication\UseCases\Commands\PasswordChange\PasswordChangeCommand;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function __construct() {}

    public function __invoke(PasswordChangeRequest $request)
    {
        $res = $this->commandBus->dispatch(
            new PasswordChangeCommand(
                email: $request->user['email'],
                password: Hash::make($request->data()->password),
                old_password: $request->data()->old_password
            ),
        );

        return response()->json([
            'data' => null,
            'message' => $res,
            'errors' => null,
        ]);
    }
}

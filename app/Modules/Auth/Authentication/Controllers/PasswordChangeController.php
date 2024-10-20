<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Requests\PasswordChangeRequest;
use App\Modules\Auth\Authentication\UseCases\Commands\PasswordChange\PasswordChangeCommandHandler;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function __construct(protected PasswordChangeCommandHandler $passwordChangeCommandHandler) {}

    public function __invoke(PasswordChangeRequest $request)
    {
        $res = $this->passwordChangeCommandHandler->handle(
            email: $request->user['email'],
            password: Hash::make($request->data()->password),
            oldPassword: $request->data()->old_password
        );

        return response()->json([
            'data' => null,
            'message' => $res,
            'errors' => null,
        ]);
    }
}

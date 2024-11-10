<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\PasswordChangeCommandHandler;
use App\Modules\Auth\Authentication\Presentation\Requests\PasswordChangeRequest;
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

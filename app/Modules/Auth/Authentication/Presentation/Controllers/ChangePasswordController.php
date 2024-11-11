<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\ChangePasswordUseCase;
use App\Modules\Auth\Authentication\Presentation\Requests\PasswordChangeRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct(protected ChangePasswordUseCase $changePasswordUseCase) {}

    public function __invoke(PasswordChangeRequest $request)
    {
        $res = $this->changePasswordUseCase->handle(
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

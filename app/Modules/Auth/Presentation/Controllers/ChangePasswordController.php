<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\UseCases\ChangePasswordUseCase;
use App\Modules\Auth\Presentation\Requests\PasswordChangeRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct(protected ChangePasswordUseCase $changePasswordUseCase) {}

    public function __invoke(PasswordChangeRequest $request)
    {
        $res = $this->changePasswordUseCase->handle(
            email: $request->user['email'],
            password: Hash::make($request->input('password')),
            oldPassword: $request->input('old_password')
        );

        return response()->json([
            'data' => null,
            'message' => $res,
            'error' => null,
            'errors' => null,
        ]);
    }
}

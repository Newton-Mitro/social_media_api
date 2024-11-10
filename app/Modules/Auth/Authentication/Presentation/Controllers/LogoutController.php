<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\LogoutUserUseCase;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(protected readonly LogoutUserUseCase $logoutUserUseCase) {}

    public function __invoke(Request $request)
    {
        $userId = request()->get('uid');
        $access_token = request()->bearerToken();
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $this->logoutUserUseCase->handle(
            $userId,
            $userAgent,
            $access_token,
        );

        return response()->json([
            'data' => null,
            'message' => 'Successfully logged out',
            'errors' => null,
        ]);
    }
}

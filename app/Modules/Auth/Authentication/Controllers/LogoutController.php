<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\UseCases\LogoutCommandHandler;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(protected readonly LogoutCommandHandler $logoutCommandHandler) {}

    public function __invoke(Request $request)
    {
        $userId = request()->get('uid');
        $access_token = request()->bearerToken();
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $this->logoutCommandHandler->handle(
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

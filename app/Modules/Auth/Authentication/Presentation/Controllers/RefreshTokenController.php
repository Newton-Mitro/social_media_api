<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\RefreshTokenCommandHandler;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public function __construct(protected RefreshTokenCommandHandler $refreshTokenCommandHandler) {}

    public function __invoke(Request $request)
    {
        $user = $request->get('user');
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $res = $this->refreshTokenCommandHandler->handle(
            userId: $user['user_id'],
            deviceName: $userAgent,
            deviceIP: $ip
        );

        return response()->json([
            'data' => $res,
            'message' => 'Token successfully refreshed.',
            'errors' => null,
        ]);
    }
}

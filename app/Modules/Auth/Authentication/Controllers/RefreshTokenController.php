<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\UseCases\Commands\RefreshToken\RefreshTokenCommand;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public function __construct() {}

    public function __invoke(Request $request)
    {
        $user = $request->get('user');
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $res = $this->commandBus->dispatch(
            new RefreshTokenCommand(
                user_id: $user['user_id'],
                device_name: $userAgent,
                device_ip: $ip
            ),
        );

        return response()->json([
            'data' => $res,
            'message' => 'Token successfully refreshed.',
            'errors' => null,
        ]);
    }
}

<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct() {}

    public function __invoke(Request $request)
    {
        $userId = request()->get('uid');
        $access_token = request()->bearerToken();
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // $this->commandBus->dispatch(
        //     new LogoutCommand($userId, $access_token, $userAgent, $ip)
        // );

        return response()->json([
            'data' => null,
            'message' => 'Successfully logged out',
            'errors' => null,
        ]);
    }
}

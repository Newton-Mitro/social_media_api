<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\FetchRefreshTokenUseCase;
use Illuminate\Http\Request;

class FetchRefreshTokenController extends Controller
{
    public function __construct(protected FetchRefreshTokenUseCase $fetchRefreshTokenUseCase) {}

    public function __invoke(Request $request)
    {
        $user = $request->get('user');
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $res = $this->fetchRefreshTokenUseCase->handle(
            userId: $user['id'],
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

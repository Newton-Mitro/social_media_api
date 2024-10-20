<?php

namespace App\Modules\Auth\Authentication\Middlewares;

use App\Modules\Auth\Authentication\Services\JwtRefreshTokenService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class JwtRefreshTokenMiddleware
{
    public function __construct(protected JwtRefreshTokenService $jwtRefreshTokenService) {}

    public function handle(Request $request, Closure $next): Response
    {
        $tokenString = $request->bearerToken();

        if (! $tokenString) {
            throw new UnauthorizedException('JWT refresh token required', Response::HTTP_UNAUTHORIZED);
        }

        $parsedToken = $this->jwtRefreshTokenService->validateToken($tokenString);

        $uid = $parsedToken->claims()->get('uid');
        $expire_at = $parsedToken->claims()->get('exp');
        $user = $parsedToken->claims()->get('user');
        // $user = $this->queryBus->ask(
        //     new FindUserQuery($uid)
        // );

        $request->merge(['uid' => $uid]);
        $request->merge(['user' => $user]);
        $request->merge(['exp' => $expire_at->getTimestamp()]);

        // Auth::setUser($user);

        return $next($request);
    }
}

<?php

namespace App\Modules\Auth\Authentication\Presentation\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\UnauthorizedException;
use App\Modules\Auth\Authentication\Application\Services\JwtRefreshTokenService;

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

        $request->merge(['uid' => $uid]);
        $request->merge(['user' => $user]);
        $request->merge(['exp' => $expire_at->getTimestamp()]);

        Auth::setUser($user);

        return $next($request);
    }
}

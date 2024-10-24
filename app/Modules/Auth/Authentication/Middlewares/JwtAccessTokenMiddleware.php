<?php

namespace App\Modules\Auth\Authentication\Middlewares;

use App\Modules\Auth\Authentication\Services\JwtAccessTokenService;
use App\Modules\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class JwtAccessTokenMiddleware
{
    public function __construct(
        protected JwtAccessTokenService $jwtAccessTokenService,
        private readonly BlacklistedTokenRepositoryInterface $blacklistedTokenRepositoryInterface
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $tokenString = $request->bearerToken();

        if (! $tokenString) {
            throw new UnauthorizedException('JWT access token required', Response::HTTP_UNAUTHORIZED);
        }

        $tokenExist = $this->blacklistedTokenRepositoryInterface->blacklistedTokenExist(
            $tokenString
        );

        if ($tokenExist) {
            throw new UnauthorizedException('Invalid token', Response::HTTP_UNAUTHORIZED);
        }

        $parsedToken = $this->jwtAccessTokenService->validateToken($tokenString);

        $uid = $parsedToken->claims()->get('uid');
        $user = $parsedToken->claims()->get('user');
        $expire_at = $parsedToken->claims()->get('exp');

        $request->merge(['uid' => $uid]);
        $request->merge(['user' => $user]);
        $request->merge(['exp' => $expire_at->getTimestamp()]);

        if ($uid) {
            // $user = $this->queryBus->ask(
            //     new FindUserQuery($uid)
            // );

            // Auth::setUser($user);

            if ($request->is('api/auth/logout')) {
                return $next($request);
            }

            if ($request->is('api/account/email/verify')) {
                return $next($request);
            }

            if ($request->is('api/account/email/resend')) {
                return $next($request);
            }

            if ($user && $user['email_verified_at']) {
                return $next($request);
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your email address is not verified.'], Response::HTTP_FORBIDDEN);
            }
        }

        // dd(Response::HTTP_UNAUTHORIZED);
        return response()->json(['message' => 'Invalid token.'], Response::HTTP_UNAUTHORIZED);
    }
}

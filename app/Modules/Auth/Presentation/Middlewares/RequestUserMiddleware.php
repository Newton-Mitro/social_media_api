<?php

namespace App\Modules\Auth\Presentation\Middlewares;

use App\Modules\Auth\Infrastructure\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Symfony\Component\HttpFoundation\Response;

class RequestUserMiddleware
{
    protected $config;

    public function __construct()
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256,
            InMemory::plainText(config('app.jwt_secret'))
        );
    }


    public function handle(Request $request, Closure $next): Response
    {
        $tokenString = $request->bearerToken();

        if ($tokenString) {
            $parsedToken = $this->config->parser()->parse($tokenString);

            $uid = $parsedToken->claims()->get('uid');
            $user = $parsedToken->claims()->get('user');
            $expire_at = $parsedToken->claims()->get('exp');

            $request->merge(['uid' => $uid]);
            $request->merge(['user' => $user]);
            $request->merge(['exp' => $expire_at->getTimestamp()]);
            $authUser = User::find($uid);
            if (!$authUser) {
                throw new UnauthorizedException('Invalid token', Response::HTTP_UNAUTHORIZED);
            }
            Auth::setUser($authUser);
        }
        return $next($request);
    }
}

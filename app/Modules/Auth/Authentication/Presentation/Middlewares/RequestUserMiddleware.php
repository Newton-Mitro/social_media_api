<?php

namespace App\Modules\Auth\Authentication\Presentation\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

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
        }
        return $next($request);
    }
}

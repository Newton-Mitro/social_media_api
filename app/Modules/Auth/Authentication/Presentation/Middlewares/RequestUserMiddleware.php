<?php

namespace App\Modules\Auth\Authentication\Presentation\Middlewares;

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            Auth::setUser(User::find($uid));
        }
        return $next($request);
    }
}

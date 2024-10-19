<?php

namespace App\Modules\Auth\Authentication\Services;

use App\Modules\Auth\User\Mappers\UserMapper;
use DateTimeImmutable;
use Exception;
use Illuminate\Validation\UnauthorizedException;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Symfony\Component\HttpFoundation\Response;

class JwtAccessTokenService
{
    protected $config;

    public function __construct()
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256,
            InMemory::plainText(config('app.jwt_secret'))
        );
    }

    public function generateToken($user)
    {
        $now = new DateTimeImmutable;
        $mappedUser = UserMapper::toUserResource($user);
        $token = $this->config->builder()
            ->issuedBy(config('app.issuer')) // Configures the issuer (iss claim)
            ->permittedFor(config('app.audience')) // Configures the audience (aud claim)
            ->identifiedBy('4f1g23a12aa', true) // Configures the id (jti claim)
            ->issuedAt($now) // Configures the time that the token was issued (iat claim)
            ->canOnlyBeUsedAfter($now->modify('+1 minute')) // Configures the time that the token can be used (nbf claim)
            // TODO: get time from .env
            ->expiresAt($now->modify(config('app.jwt_expire_at'))) // Configures the expiration time of the token (exp claim)
            //            ->expiresAt($now->modify('+1 hour')) // Configures the expiration time of the token (exp claim)
            ->relatedTo('access_token') //JWT Subject
            ->withClaim('user', $mappedUser) // Configures a new claim, called "user"
            ->withClaim('uid', $user->getUserId()) // Configures a new claim, called "user"
            ->getToken($this->config->signer(), $this->config->signingKey()); // Retrieves the generated token

        return $token->toString();
    }

    public function validateToken($token)
    {
        try {
            $parsedToken = $this->config->parser()->parse($token); // Replace $jwt with your token string
            $constraints = [
                new SignedWith($this->config->signer(), $this->config->signingKey()),
            ];
        } catch (Exception) {
            throw new UnauthorizedException("Invalid token, can't be parse token.", Response::HTTP_UNAUTHORIZED);
        }

        if ($this->config->validator()->validate($parsedToken, ...$constraints)) {
            if (! $parsedToken->isPermittedFor(config('app.audience'))) {
                throw new UnauthorizedException('Invalid token', Response::HTTP_UNAUTHORIZED);
            }

            if (! $parsedToken->hasBeenIssuedBy(config('app.issuer'))) {
                throw new UnauthorizedException('Invalid token', Response::HTTP_UNAUTHORIZED);
            }

            if ($parsedToken->isExpired(new DateTimeImmutable('now'))) {
                throw new UnauthorizedException('Token has been expired or revoked.', Response::HTTP_UNAUTHORIZED);
            }
        } else {
            throw new UnauthorizedException('Token signature mismatch.', Response::HTTP_UNAUTHORIZED);
        }

        return $parsedToken;
    }
}

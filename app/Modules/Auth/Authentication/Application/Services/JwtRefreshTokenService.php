<?php

namespace App\Modules\Auth\Authentication\Application\Services;

use App\Modules\Auth\Authentication\Application\Resources\UserResource;
use App\Modules\Auth\Authentication\Domain\Entities\DeviceEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\DeviceRepositoryInterface;
use DateTimeImmutable;
use Exception;
use Illuminate\Validation\UnauthorizedException;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Symfony\Component\HttpFoundation\Response;

class JwtRefreshTokenService
{
    protected $config;

    public function __construct(protected readonly DeviceRepositoryInterface $deviceRepository)
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256,
            InMemory::plainText(config('app.jwt_refresh_secret'))
        );
    }

    public function generateToken(UserResource $user, string $device_name, string $device_ip)
    {
        $now = new DateTimeImmutable;
        $token = $this->config->builder()
            ->issuedBy(config('app.issuer')) // Configures the issuer (iss claim)
            ->permittedFor(config('app.audience')) // Configures the audience (aud claim)
            ->identifiedBy('4f1g23a12aa', true) // Configures the id (jti claim)
            ->issuedAt($now) // Configures the time that the token was issued (iat claim)
            //            ->canOnlyBeUsedAfter($now->modify('+1 minute')) // Configures the time that the token can be used (nbf claim)
            ->expiresAt($now->modify(config('app.jwt_refresh_expire_at'))) // Configures the expiration time of the token (exp claim)
            //            ->expiresAt($now->modify('+1 hour')) // Configures the expiration time of the token (exp claim)
            ->relatedTo('access_token') //JWT Subject
            ->withClaim('user', $user) // Configures a new claim, called "uid"
            ->withClaim('uid', $user->id) // Configures a new claim, called "uid"
            ->getToken($this->config->signer(), $this->config->signingKey()); // Retrieves the generated token

        $deviceEntity = $this->deviceRepository->findDeviceByUserIdAndDeviceName(
            $user->id,
            $device_name
        );

        if ($deviceEntity) {
            $deviceEntity->setDeviceToken($token->toString());
            $deviceEntity->setUpdatedAt(new DateTimeImmutable);

            $this->deviceRepository->save(
                $deviceEntity
            );
        } else {
            $device = new DeviceEntity(
                0,
                $user->id,
                $device_name,
                $device_ip,
                $token->toString(),
                ''
            );
            $this->deviceRepository->save(
                $device
            );
        }

        return $token->toString();
    }

    public function validateToken(string $token)
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

            $deviceEntity = $this->deviceRepository->findDeviceWithToken($token);

            if ($deviceEntity === null) {
                throw new UnauthorizedException('Invalid token', Response::HTTP_UNAUTHORIZED);
            }
        } else {
            throw new UnauthorizedException('Token signature mismatch.', Response::HTTP_UNAUTHORIZED);
        }

        return $parsedToken;
    }
}

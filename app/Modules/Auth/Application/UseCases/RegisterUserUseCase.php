<?php

namespace App\Modules\Auth\Application\UseCases;

use App\Core\Enums\OtpTypes;
use App\Core\Utilities\OTPGenerator;
use App\Modules\Auth\Application\DTOs\AuthUserDTO;
use App\Modules\Auth\Application\Events\UserRegistered;
use App\Modules\Auth\Application\Mappers\UserDTOMapper;
use App\Modules\Auth\Application\Services\JwtAccessTokenService;
use App\Modules\Auth\Application\Services\JwtRefreshTokenService;
use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Auth\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Domain\Interfaces\AuthRepositoryInterface;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Infrastructure\Mail\VerificationEmail;
use Carbon\Carbon;
use DateTimeImmutable;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class RegisterUserUseCase
{
    public function __construct(
        protected JwtAccessTokenService $accessTokenService,
        protected JwtRefreshTokenService $refreshTokenService,
        protected UserRepositoryInterface $userRepository,
        protected AuthRepositoryInterface $authRepository
    ) {}

    public function handle(string $name, string $email, string $password, string $deviceName, string $deviceIP): AuthUserDTO
    {
        // Check if user already exist
        $existingUser = $this->userRepository->findByEmail($email);

        if ($existingUser) {
            throw new ErrorException('User already exist', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Generate OTP
        $otpValidTime = OTPGenerator::getValidateTime();
        $otp = OTPGenerator::generateOTP();
        $expiresAt = OTPGenerator::generateExpireTime();

        $userEntity = new UserEntity(
            name: $name,
            email: $email,
            password: $password,
            lastLoggedIn: new DateTimeImmutable()
        );

        $userOtpEntity = new UserOtpEntity(
            otp: $otp,
            type: OtpTypes::USER_REGISTERED,
            userId: $userEntity->getId(),
            expiresAt: $expiresAt,
            isVerified: false,
            token: null,
            createdAt: new DateTimeImmutable,
            updatedAt: new DateTimeImmutable
        );

        // Store OTP/Persist user to db
        $this->authRepository->register($userEntity, $userOtpEntity);

        // Send OTP to user email
        Mail::to($email)->send(new VerificationEmail($userEntity, $otp, $otpValidTime));

        Event::dispatch(new UserRegistered($userEntity));

        $mappedUser = UserDTOMapper::fromEntity($userEntity);

        // Generate user token here
        $access_token = $this->accessTokenService->generateToken($mappedUser);
        $refresh_token = $this->refreshTokenService->generateToken($mappedUser, $deviceName, $deviceIP);

        $authUser = new AuthUserDTO(user: $mappedUser, access_token: $access_token, refresh_token: $refresh_token);
        return $authUser;
    }
}

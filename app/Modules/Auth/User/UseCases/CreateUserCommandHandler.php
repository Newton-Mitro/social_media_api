<?php

namespace App\Features\Auth\User\UseCases\Commands\CreateUser;

use App\Features\Auth\User\BusinessModels\UserModel;
use App\Features\Auth\User\Interfaces\UserRepositoryInterface;
use ErrorException;
use Illuminate\Support\Str;

class CreateUserCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function handle(CreateUserCommand $command): string
    {
        // Check if user already exist
        $existingUser = $this->repository->findUserByEmail($command->getEmail());

        if ($existingUser instanceof \App\Features\Auth\User\BusinessModels\UserModel) {
            throw new ErrorException('User already exist');
        }

        // Create User Business Model
        $userModel = new UserModel(
            userId: Str::id()->toString(),
            name: $command->getName(),
            userName: Str::slug($command->getName(), '_'),
            email: $command->getEmail(),
            password: $command->getPassword(),
            profilePicture: $command->getProfilePicture(),
            coverPhoto: $command->getCoverPhoto(),
            emailVerifiedAt: $command->getEmailVerifiedAt(),
            otp: $command->getOtp(),
            otpExpiresAt: $command->getOtpExpiresAt(),
            otpVerified: $command->isOtpVerified(),
            lastLoggedIn: $command->getLastLoggedIn(),
        );

        // Persist user in database
        $this->repository->create($userModel);

        return $userModel->getUserId();
    }
}

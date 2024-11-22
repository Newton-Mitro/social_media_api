<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Profile\Application\DTOs\ProfileAggregateDTO;
use App\Modules\Profile\Application\Mappers\ProfileAggregateMapper;
use App\Modules\Profile\Domain\Repositories\ProfileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ChangeCoverPhotoUseCase
{
    public function __construct(
        protected ProfileRepositoryInterface $profileRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(string $userId, UploadedFile $coverPhoto): ProfileAggregateDTO
    {
        $userAggregate = $this->profileRepository->fetchUserProfile(
            $userId
        );

        // Check if the user has an existing cover photo
        if ($userAggregate->user->getProfile()->getCoverPhoto()) {
            // Get the existing photo path
            $existingPhotoPath = parse_url($userAggregate->user->getProfile()->getCoverPhoto(), PHP_URL_PATH);
            // Delete the existing photo
            Storage::disk('public')->delete(ltrim($existingPhotoPath, '/'));
        }

        // Store the new cover photo
        $path = $coverPhoto->store('users', 'public');

        $userAggregate->user->getProfile()->updateProfile(
            $userAggregate->user->getProfile()->getMobileNumber(),
            $userAggregate->user->getProfile()->getProfilePicture(),
            $path,
            $userAggregate->user->getProfile()->getBio()
        );

        $this->userRepository->save($userAggregate);

        return ProfileAggregateMapper::toDTO($userAggregate);
    }
}

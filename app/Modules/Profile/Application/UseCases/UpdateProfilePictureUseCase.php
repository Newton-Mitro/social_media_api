<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Profile\Application\DTOs\ProfileAggregateDTO;
use App\Modules\Profile\Application\Mappers\ProfileAggregateMapper;
use App\Modules\Profile\Domain\Repositories\ProfileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProfilePictureUseCase
{
    public function __construct(
        protected ProfileRepositoryInterface $profileRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(string $userId, UploadedFile $profilePhoto): ProfileAggregateDTO
    {
        $userAggregate = $this->profileRepository->fetchUserProfile($userId);

        // Delete Old Photo
        if ($userAggregate->user->getProfile()->getProfilePicture()) {
            // Get the existing photo path
            $existingPhotoPath = parse_url($userAggregate->user->getProfile()->getProfilePicture(), PHP_URL_PATH);
            // Delete the existing photo
            Storage::disk('public')->delete(ltrim($existingPhotoPath, '/'));
        }

        // Store the new profile photo
        $path = $profilePhoto->store('users', 'public');

        $userAggregate->user->getProfile()->updateProfile(
            $userAggregate->user->getProfile()->getMobileNumber(),
            $path,
            $userAggregate->user->getProfile()->getCoverPhoto(),
            $userAggregate->user->getProfile()->getBio()
        );

        $this->userRepository->save($userAggregate);

        return ProfileAggregateMapper::toDTO($userAggregate);
    }
}

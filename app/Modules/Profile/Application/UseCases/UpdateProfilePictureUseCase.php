<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Profile\Application\DTOs\ProfileAggregateDTO;
use App\Modules\Profile\Application\Mappers\ProfileAggregateDTOMapper;
use App\Modules\Profile\Domain\Interfaces\ProfileRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProfilePictureUseCase
{
    public function __construct(
        protected ProfileRepositoryInterface $profileRepository,
    ) {}

    public function handle(string $userId, UploadedFile $profilePhoto): ProfileAggregateDTO
    {
        $userAggregate = $this->profileRepository->fetchUserProfile($userId);

        // Delete Old Photo
        if ($userAggregate->profile->getProfilePicture()) {
            // Get the existing photo path
            $existingPhotoPath = parse_url($userAggregate->profile->getProfilePicture(), PHP_URL_PATH);
            // Delete the existing photo
            Storage::disk('public')->delete(ltrim($existingPhotoPath, '/'));
        }

        // Store the new profile photo
        $path = $profilePhoto->store('users', 'public');

        $userAggregate->profile->updateProfile(
            $userAggregate->profile->getMobileNumber(),
            $path,
            $userAggregate->profile->getCoverPhoto(),
            $userAggregate->profile->getBio()
        );

        $this->profileRepository->save($userAggregate);

        return ProfileAggregateDTOMapper::fromEntity($userAggregate);
    }
}

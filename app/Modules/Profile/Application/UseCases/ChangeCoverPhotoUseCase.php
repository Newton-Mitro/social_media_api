<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserDTOMapper;
use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Profile\Application\DTOs\ProfileAggregateDTO;
use App\Modules\Profile\Application\Mappers\ProfileAggregateDTOMapper;
use App\Modules\Profile\Domain\Interfaces\ProfileRepositoryInterface;
use App\Modules\Profile\Infrastructure\Repositories\ProfileRepository;
use DateTimeImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ChangeCoverPhotoUseCase
{
    public function __construct(
        protected ProfileRepositoryInterface $profileRepository,
    ) {}

    public function handle(string $userId, UploadedFile $coverPhoto): ProfileAggregateDTO
    {
        $userAggregate = $this->profileRepository->fetchUserProfile(
            $userId
        );

        // Check if the user has an existing cover photo
        if ($userAggregate->profile->getCoverPhoto()) {
            // Get the existing photo path
            $existingPhotoPath = parse_url($userAggregate->profile->getCoverPhoto(), PHP_URL_PATH);
            // Delete the existing photo
            Storage::disk('public')->delete(ltrim($existingPhotoPath, '/'));
        }

        // Store the new cover photo
        $path = $coverPhoto->store('users', 'public');

        $userAggregate->profile->updateProfile(
            $userAggregate->profile->getMobileNumber(),
            $userAggregate->profile->getProfilePicture(),
            $path,
            $userAggregate->profile->getBio()
        );

        $this->profileRepository->save($userAggregate);

        return ProfileAggregateDTOMapper::fromEntity($userAggregate);
    }
}

<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserDTOMapper;
use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Auth\Domain\Interfaces\RepositoryInterface;
use DateTimeImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProfilePictureUseCase
{
    public function __construct(
        protected RepositoryInterface $userRepository,
    ) {}

    public function handle(string $userId, UploadedFile $profilePhoto): UserDTO
    {
        $user = $this->userRepository->findById($userId);

        // Delete Old Photo
        if ($user->getProfilePicture()) {
            // Get the existing photo path
            $existingPhotoPath = parse_url($user->getProfilePicture(), PHP_URL_PATH);
            // Delete the existing photo
            Storage::disk('public')->delete(ltrim($existingPhotoPath, '/'));
        }

        // Store the new profile photo
        $path = $profilePhoto->store('users', 'public');

        $user->setUpdatedAt(new DateTimeImmutable());
        $user->setProfilePicture($path);

        $this->userRepository->save($user);

        return UserDTOMapper::toDTO($user);
    }
}

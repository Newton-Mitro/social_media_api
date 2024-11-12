<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserResourceMapper;
use App\Modules\Auth\Application\Resources\UserResource;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateProfilePictureUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $userId, UploadedFile $profilePhoto): UserResource
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

        return UserResourceMapper::toResource($user);
    }
}

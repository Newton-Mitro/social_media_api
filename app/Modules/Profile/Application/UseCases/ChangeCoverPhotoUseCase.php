<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserResourceMapper;
use App\Modules\Auth\Application\Resources\UserResource;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ChangeCoverPhotoUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $userId, UploadedFile $coverPhoto): UserResource
    {
        $user = $this->userRepository->findById(
            $userId
        );

        // Check if the user has an existing cover photo
        if ($user->getCoverPhoto()) {
            // Get the existing photo path
            $existingPhotoPath = parse_url($user->getCoverPhoto(), PHP_URL_PATH);
            // Delete the existing photo
            Storage::disk('public')->delete(ltrim($existingPhotoPath, '/'));
        }

        // Store the new cover photo
        $path = $coverPhoto->store('users', 'public');

        $user->setUpdatedAt(new DateTimeImmutable());
        $user->setCoverPhoto($path);

        $this->userRepository->save($user);

        return UserResourceMapper::toResource($user);
    }
}

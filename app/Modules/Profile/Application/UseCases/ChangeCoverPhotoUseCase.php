<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserDTOMapper;
use App\Modules\Auth\Application\DTOs\UserDTO;
use App\Modules\Auth\Domain\Interfaces\RepositoryInterface;
use DateTimeImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ChangeCoverPhotoUseCase
{
    public function __construct(
        protected RepositoryInterface $userRepository,
    ) {}

    public function handle(string $userId, UploadedFile $coverPhoto): UserDTO
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

        return UserDTOMapper::toDTO($user);
    }
}

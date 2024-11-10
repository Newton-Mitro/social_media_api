<?php

namespace App\Modules\Auth\Authentication\Application\UseCases;

use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateCoverPictureCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $userId, UploadedFile $coverPhoto): ?UserEntity
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

        if ($this->userRepository->update($userId, $user)) {
            return $user;
        }

        throw new Exception('User update has failed!', Response::HTTP_BAD_REQUEST);
    }
}

<?php

namespace App\Modules\Auth\User\UseCases;

use Exception;
use DateTimeImmutable;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;

class UpdateProfilePictureCommandHandler
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    public function handle(string $userId, UploadedFile $profilePhoto): ?UserModel
    {
        $user = $this->userRepository->findById(
            $userId
        );


        $path = $profilePhoto->store('users', 'public');

        // Delete Old Photo
        // if ($user->getCoverPhoto()) {
        //     @unlink(public_path('app/public/' . $basePath) . $user->getCoverPhoto());
        // }

        $user->setUpdatedAt(new DateTimeImmutable());
        $user->setProfilePicture(asset(Storage::url($path)));

        if ($this->userRepository->update($userId, $user)) {
            return $user;
        }

        throw new Exception('User update has failed!', Response::HTTP_BAD_REQUEST);
    }
}

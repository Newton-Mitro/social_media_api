<?php

namespace App\Modules\Auth\User\UseCases;

use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
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

    public function handle(string $userId, UploadedFile $coverPhoto): ?UserModel
    {
        $user = $this->userRepository->findById(
            $userId
        );


        $path = $coverPhoto->store('users', 'public');

        // Delete Old Photo
        // if ($user->getCoverPhoto()) {
        //     @unlink(public_path('app/public/' . $basePath) . $user->getCoverPhoto());
        // }

        $user->setUpdatedAt(new DateTimeImmutable());
        $user->setCoverPhoto(asset(Storage::url($path)));

        if ($this->userRepository->update($userId, $user)) {
            return $user;
        }

        throw new Exception('User update has failed!', Response::HTTP_BAD_REQUEST);
    }
}

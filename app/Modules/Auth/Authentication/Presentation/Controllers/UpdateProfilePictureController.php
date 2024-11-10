<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use Exception;
use App\Core\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserMapper;
use App\Modules\Auth\Authentication\Presentation\Requests\UpdateProfilePictureRequest;
use App\Modules\Auth\Authentication\Application\UseCases\UpdateProfilePictureCommandHandler;

class UpdateProfilePictureController extends Controller
{
    public function __construct(protected readonly UpdateProfilePictureCommandHandler $updateProfilePictureCommandHandler) {}

    public function __invoke(UpdateProfilePictureRequest $request)
    {
        // dd($request);
        if ($request->hasFile('profilePhoto')) {

            $image = $request->file('profilePhoto');
            $user = $this->updateProfilePictureCommandHandler->handle(
                userId: $request->user['user_id'],
                profilePhoto: $image,
            );

            return response()->json([
                'data' => UserMapper::toUserResource($user),
                'message' => 'Profile Picture Updated Successfully.',
                'errors' => null,
            ], Response::HTTP_CREATED);
        }

        throw new Exception('User profile update has failed!', Response::HTTP_BAD_REQUEST);
    }
}

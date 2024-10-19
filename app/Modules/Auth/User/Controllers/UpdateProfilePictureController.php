<?php

namespace App\Features\Auth\User\Controllers;

use Exception;
use DateTimeImmutable;
use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\User\Mappers\UserMapper;
use Symfony\Component\HttpFoundation\Response;
use App\Features\Auth\User\Requests\UpdateProfilePictureRequest;
use App\Features\Auth\User\UseCases\Queries\FindUser\FindUserQuery;
use App\Features\Auth\User\UseCases\Commands\UpdateUser\UpdateProfilePictureCommand;

class UpdateProfilePictureController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {}

    public function __invoke(UpdateProfilePictureRequest $request)
    {
        // dd($request);
        if ($request->hasFile('profilePhoto')) {

            $user = $this->queryBus->ask(
                new FindUserQuery($request->user['user_id'])
            );

            $basePath = 'users/profile/';
            // Delete Old Photo
            if ($user->getProfilePicture()) {
                @unlink(public_path('app/public/' . $basePath) . $user->getProfilePicture());
            }

            $image = $request->file('profilePhoto');
            $storagePath = $image->store($basePath, 'public');
            $user = $this->commandBus->dispatch(
                new UpdateProfilePictureCommand(
                    userId: $request->user['user_id'],
                    profilePicture: $basePath . basename($storagePath),
                )
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

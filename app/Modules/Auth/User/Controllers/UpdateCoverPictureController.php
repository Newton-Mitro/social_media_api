<?php

namespace App\Modules\Auth\User\Controllers;

use Exception;
use App\Core\Controllers\Controller;
use App\Modules\Auth\User\Mappers\UserMapper;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Auth\User\Requests\UpdateCoverPictureRequest;
use App\Modules\Auth\User\UseCases\Queries\FindUser\FindUserQuery;
use App\Modules\Auth\User\UseCases\Commands\UpdateUser\UpdateCoverPictureCommand;

class UpdateCoverPictureController extends Controller
{
    public function __construct() {}

    public function __invoke(UpdateCoverPictureRequest $request)
    {
        // dd($request);
        if ($request->hasFile('coverPhoto')) {

            $user = $this->queryBus->ask(
                new FindUserQuery($request->user['user_id'])
            );

            $basePath = 'users/cover/';
            // Delete Old Photo
            if ($user->getCoverPhoto()) {
                @unlink(public_path('app/public/' . $basePath) . $user->getCoverPhoto());
            }

            $image = $request->file('coverPhoto');
            $storagePath = $image->store($basePath, 'public');

            $user = $this->commandBus->dispatch(
                new UpdateCoverPictureCommand(
                    userId: $request->user['user_id'],
                    coverPhoto: $basePath . basename($storagePath),
                ),
            );

            return response()->json([
                'data' => UserMapper::toUserResource($user),
                'message' => 'Cover Picture Updated Successfully.',
                'errors' => null,
            ], Response::HTTP_CREATED);
        }

        throw new Exception('User cover update has failed!', Response::HTTP_BAD_REQUEST);
    }
}

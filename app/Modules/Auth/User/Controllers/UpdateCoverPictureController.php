<?php

namespace App\Modules\Auth\User\Controllers;

use Exception;
use App\Core\Controllers\Controller;
use App\Modules\Auth\User\Mappers\UserMapper;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Auth\User\Requests\UpdateCoverPictureRequest;
use App\Modules\Auth\User\UseCases\UpdateCoverPictureCommandHandler;

class UpdateCoverPictureController extends Controller
{
    public function __construct(protected readonly UpdateCoverPictureCommandHandler $logoutCommandHandler) {}

    public function __invoke(UpdateCoverPictureRequest $request)
    {
        if ($request->hasFile('coverPhoto')) {
            $image = $request->file('coverPhoto');
            $user = $this->logoutCommandHandler->handle(
                userId: $request->user['user_id'],
                coverPhoto: $image,
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

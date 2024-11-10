<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\UpdateCoverPictureCommandHandler;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserMapper;
use App\Modules\Auth\Authentication\Presentation\Requests\UpdateCoverPictureRequest;
use Exception;
use Symfony\Component\HttpFoundation\Response;

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

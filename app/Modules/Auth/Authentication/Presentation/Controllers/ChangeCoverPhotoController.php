<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\ChangeCoverPhotoUseCase;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserMapper;
use App\Modules\Auth\Authentication\Presentation\Requests\ChangeCoverPhotoRequest;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ChangeCoverPhotoController extends Controller
{
    public function __construct(protected readonly ChangeCoverPhotoUseCase $changeCoverPhotoUseCase) {}

    public function __invoke(ChangeCoverPhotoRequest $request)
    {
        if ($request->hasFile('coverPhoto')) {
            $image = $request->file('coverPhoto');
            $user = $this->changeCoverPhotoUseCase->handle(
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

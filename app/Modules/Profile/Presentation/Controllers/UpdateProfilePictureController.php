<?php

namespace App\Modules\Profile\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Profile\Application\UseCases\UpdateProfilePictureUseCase;
use App\Modules\Profile\Presentation\Requests\UpdateProfilePictureRequest;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UpdateProfilePictureController extends Controller
{
    public function __construct(protected readonly UpdateProfilePictureUseCase $updateProfilePictureUseCase) {}

    public function __invoke(UpdateProfilePictureRequest $request)
    {
        if ($request->hasFile('profilePhoto')) {
            $image = $request->file('profilePhoto');
            $user = $this->updateProfilePictureUseCase->handle(
                userId: $request->user['id'],
                profilePhoto: $image,
            );

            return response()->json([
                'data' => $user,
                'message' => 'Profile Picture Updated Successfully.',
                'error' => null,
                'errors' => null,
            ], Response::HTTP_CREATED);
        }

        throw new Exception('User profile update has failed!', Response::HTTP_BAD_REQUEST);
    }
}

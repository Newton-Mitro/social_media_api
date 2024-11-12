<?php

namespace App\Modules\Profile\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Profile\Application\UseCases\ChangeCoverPhotoUseCase;
use App\Modules\Profile\Presentation\Requests\ChangeCoverPhotoRequest;
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
                userId: $request->user['id'],
                coverPhoto: $image,
            );

            return response()->json([
                'data' => $user,
                'message' => 'Cover Picture Updated Successfully.',
                'error' => null,
                'errors' => null,
            ], Response::HTTP_CREATED);
        }

        throw new Exception('User cover update has failed!', Response::HTTP_BAD_REQUEST);
    }
}

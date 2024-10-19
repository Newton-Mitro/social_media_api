<?php

namespace App\Modules\Post\Controllers;

use App\Core\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Post\Requests\UpdatePostPrivacyRequest;
use App\Modules\Post\UseCases\Commands\UpdatePostPrivacy\UpdatePostPrivacyCommand;

class UpdatePostPrivacyController extends Controller
{
    public function __construct() {}
    public function __invoke(UpdatePostPrivacyRequest $request)
    {
        $this->commandBus->dispatch(
            new UpdatePostPrivacyCommand(
                userId: $request->user['user_id'],
                postId: $request->post_id,
                privacyId: $request->privacy_id
            ),
        );
        return response()->json([
            'data' => null,
            'message' => 'Post Privacy Updated Successfully.',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}

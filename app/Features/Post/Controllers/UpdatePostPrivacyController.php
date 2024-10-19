<?php

namespace App\Features\Post\Controllers;

use Exception;
use DateTimeImmutable;
use Psr\Log\NullLogger;
use App\Core\Bus\ICommandBus;
use App\Features\Post\Models\Post;
use App\Core\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Features\Post\Requests\UpdatePostRequest;
use App\Features\Post\Requests\UpdatePostPrivacyRequest;
use App\Features\Auth\User\UseCases\Queries\FindUser\FindUserQuery;
use App\Features\Post\UseCases\Commands\UpdatePostPrivacy\UpdatePostPrivacyCommand;

class UpdatePostPrivacyController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus
    ) {
    }
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

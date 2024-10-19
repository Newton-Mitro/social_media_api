<?php

namespace App\Features\Post\Controllers;

use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Features\Post\Requests\CreatePostRequest;
use App\Features\Post\UseCases\Commands\CreatePost\CreatePostCommand;

class CreatePostController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus   $queryBus,
    ) {}

    public function __invoke(CreatePostRequest $request)
    {
        $attachments = [];
        if ($request->hasFile('attachments')) {

            $files = $request->file('attachments');
            foreach ($files as $file) {

                $contentType = $file->getMimeType();
                if (explode('/', $contentType)[0] == 'image') {
                    $basePath = 'posts/images/';
                    $storagePath = $file->store($basePath, 'public');
                    $attachments[] = [
                        'content_url' => asset('storage/' . $basePath),
                        'content_name' => basename($storagePath),
                        'content_type' => $contentType
                    ];
                } else if (explode('/', $contentType)[0] == 'video') {
                    $basePath = 'posts/videos/';
                    $storagePath = $file->store($basePath, 'public');
                    $attachments[] = [
                        'content_url' => asset('storage/' . $basePath),
                        'content_name' => basename($storagePath),
                        'content_type' => $contentType
                    ];
                }
            }
        }

        $postBody = $request->get('body');

        $post = $this->commandBus->dispatch(
            new CreatePostCommand(
                userId: $request->user['user_id'],
                body: $postBody,
                privacyId: 1,
                attachments: $attachments
            ),
        );

        return response()->json([
            'data' => $post,
            'message' => 'Post has inserted Successfully.',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}

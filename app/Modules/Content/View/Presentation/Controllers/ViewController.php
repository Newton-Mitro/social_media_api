<?php

namespace App\Modules\Content\View\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Post\Application\UseCases\CreatePostUseCase;
use App\Modules\Content\Post\Application\UseCases\DeletePostUseCase;
use App\Modules\Content\Post\Application\UseCases\GetPostsUseCase;
use App\Modules\Content\Post\Application\UseCases\UpdatePostUseCase;
use App\Modules\Content\Post\Application\UseCases\ViewPostUseCase;
use Illuminate\Http\Response;

class ViewController extends Controller
{
    public function __construct(
        protected GetPostsUseCase $getPostsUseCase,
        protected CreatePostUseCase $createPostUseCase,
        protected UpdatePostUseCase $updatePostUseCase,
        protected ViewPostUseCase $viewPostUseCase,
        protected DeletePostUseCase $deletePostUseCase,
    ) {}

    public function viewAPost($id)
    {
        try {
            $authId = request()->get('uid');
            $post = $this->viewPostUseCase->handle($id);

            return response()->json([
                'data' => $post,
                'message' => 'Post retrieved successfully.',
                'error' => null,
                'errors' => null,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to fetch post.',
                'errors' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function viewAAttachment($id)
    {
        $authId = request()->get('uid');
        $post = 'unlike_usecase';
        return response()->json(['data' => $post, 'message' => 'Successfully reacted to a post.'], 204);
    }
}

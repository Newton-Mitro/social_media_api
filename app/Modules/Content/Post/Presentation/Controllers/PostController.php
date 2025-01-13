<?php

namespace App\Modules\Content\Post\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Post\Application\Requests\StorePostRequest;
use App\Modules\Content\Post\Application\Requests\UpdatePostRequest;
use App\Modules\Content\Post\Application\UseCases\CreatePostUseCase;
use App\Modules\Content\Post\Application\UseCases\DeletePostUseCase;
use App\Modules\Content\Post\Application\UseCases\GetPostsUseCase;
use App\Modules\Content\Post\Application\UseCases\UpdatePostUseCase;
use App\Modules\Content\Post\Application\UseCases\ViewPostUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct(
        protected GetPostsUseCase $getPostsUseCase,
        protected CreatePostUseCase $createPostUseCase,
        protected UpdatePostUseCase $updatePostUseCase,
        protected ViewPostUseCase $viewPostUseCase,
        protected DeletePostUseCase $deletePostUseCase,
    ) {}

    public function index(Request $request)
    {
        $authId = request()->get('uid');
        $limit = request()->input('limit', 10);
        $offset = request()->input('offset', 0);

        $posts =  $this->getPostsUseCase->handle(
            limit: $limit,
            offset: $offset,
            auth_user_id: $authId
        );

        return response()->json([
            'data' => $posts,
            'message' => 'Posts retrieved successfully.',
            'error' => null,
            'errors' => null,
        ], Response::HTTP_OK);
    }

    public function usersPosts($userId)
    {
        $authId = request()->get('uid');
        $limit = request()->input('limit', 10);
        $offset = request()->input('offset', 0);

        $posts =  $this->getPostsUseCase->handle(
            limit: $limit,
            offset: $offset,
            auth_user_id: $userId
        );

        return response()->json([
            'data' => $posts,
            'message' => 'Posts retrieved successfully.',
            'error' => null,
            'errors' => null,
        ], Response::HTTP_OK);
    }



    public function store(StorePostRequest $request)
    {
        try {
            $post = $this->createPostUseCase->handle($request);

            return response()->json([
                'data' => $post,
                'message' => 'Post created successfully.',
                'errors' => null,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to create post.',
                'errors' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $post = $this->updatePostUseCase->handle($request, $id);

            return response()->json([
                'data' => $post,
                'message' => 'Post updated successfully.',
                'errors' => null,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to update post.',
                'errors' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $this->deletePostUseCase->handle($id);

            return response()->json([
                'data' => null,
                'message' => 'Post deleted successfully.',
                'errors' => null,
            ], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'message' => 'Failed to remove post.',
                'errors' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

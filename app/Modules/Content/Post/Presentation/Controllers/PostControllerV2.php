<?php

namespace App\Modules\Content\Post\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Post\Application\Requests\StorePostRequestV2;
use App\Modules\Content\Post\Application\Requests\UpdatePostRequestV2;
use App\Modules\Content\Post\Application\UseCases\CreatePostUseCaseV2;
use App\Modules\Content\Post\Application\UseCases\UpdatePostUseCaseV2;
use Illuminate\Http\Response;

class PostControllerV2 extends Controller
{
    public function __construct(
        protected CreatePostUseCaseV2 $createPostUseCase,
        protected UpdatePostUseCaseV2 $updatePostUseCase,
    ) {}

    public function store(StorePostRequestV2 $request)
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

    public function update(UpdatePostRequestV2 $request, $id)
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
}

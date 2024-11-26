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
use App\Modules\Content\Post\Infrastructure\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct(
        protected GetPostsUseCase $fetchPostsUseCase,
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

        $posts =  $this->fetchPostsUseCase->handle(
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

        $posts =  $this->fetchPostsUseCase->handle(
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

    public function show($id)
    {
        $authId = request()->get('uid');
        $post = $this->viewPostUseCase->handle($id);

        return response()->json([
            'data' => $post,
            'message' => 'Post retrieved successfully.',
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
        $this->deletePostUseCase->handle($id);

        return response()->json([
            'data' => null,
            'message' => 'Post deleted successfully.',
            'errors' => null,
        ], Response::HTTP_NO_CONTENT);
    }

    protected function handleAttachments(Request $request, Post $post)
    {
        if (request()->hasFile('attachments')) {
            foreach (request()->file('attachments') as $file) {
                $this->handleNewAttachment($file, $post);
            }
        }
    }

    protected function handleNewAttachment($file, Post $post)
    {
        $path = $file->store('uploads', 'public');
        $post->attachments()->create([
            'file_name' => basename($path),
            'file_url' => asset(Storage::url($path)),
            'thumbnail_url' => asset(Storage::url($path)),
            'mime_type' => $file->getMimeType(),
            'file_path' => $path,
        ]);
    }

    public function like($id)
    {
        $authId = request()->get('uid');
        $post = 'like_usecase';
        return response()->json(['data' => $post, 'message' => 'Post liked successfully.'], 201);
    }

    public function unlike($id)
    {
        $authId = request()->get('uid');
        $post = 'unlike_usecase';
        return response()->json(['data' => $post, 'message' => 'Post unliked successfully.'], 204);
    }

    public function share($id)
    {
        $authId = request()->get('uid');
        $post = 'share_usecase';
        return response()->json(['data' => $post, 'message' => 'Post shared successfully.'], 201);
    }
}

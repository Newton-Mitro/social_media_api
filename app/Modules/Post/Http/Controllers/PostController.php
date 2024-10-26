<?php

namespace App\Modules\Post\Http\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Post\Application\UseCases\PostService;
use App\Modules\Post\Http\Requests\StorePostRequest;
use App\Modules\Post\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $posts = $this->postService->getAllPosts($perPage);

        return response()->json(['data' => $posts, 'message' => 'Posts retrieved successfully.'], 200);
    }

    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return response()->json(['data' => $post, 'message' => 'Post retrieved successfully.'], 200);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $post = $this->postService->createPost($data);

        return response()->json([
            'data' => $post,
            'message' => 'Post created successfully.',
            'errors' => null,
        ], 201);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $data = $request->validated();
        $post = $this->postService->updatePost($id, $data);

        return response()->json([
            'data' => $post,
            'message' => 'Post updated successfully.',
            'errors' => null,
        ], 200);
    }

    public function destroy($id)
    {
        $this->postService->deletePost($id);
        return response()->json(['message' => 'Post deleted successfully.'], 204);
    }

    public function like($id)
    {
        $like = $this->postService->likePost($id);
        return response()->json(['data' => $like, 'message' => 'Post liked successfully.'], 201);
    }

    public function unlike($id)
    {
        $this->postService->unlikePost($id);
        return response()->json(['message' => 'Post unliked successfully.'], 204);
    }

    public function share($id)
    {
        $share = $this->postService->sharePost($id);
        return response()->json(['data' => $share, 'message' => 'Post shared successfully.'], 201);
    }
}

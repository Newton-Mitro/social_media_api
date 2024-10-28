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
        $authId = request()->get('uid');
        $perPage = $request->input('per_page', 10);
        $posts = $this->postService->getAllPosts($perPage, $authId);

        return response()->json(['data' => $posts, 'message' => 'Posts retrieved successfully.'], 200);
    }

    public function show($id)
    {
        $authId = request()->get('uid');
        $post = $this->postService->getPostById($id, $authId);
        return response()->json(['data' => $post, 'message' => 'Post retrieved successfully.'], 200);
    }

    public function store(StorePostRequest $request)
    {
        $authId = request()->get('uid');
        $data = $request->validated();
        $post = $this->postService->createPost($data, $authId);

        return response()->json([
            'data' => $post,
            'message' => 'Post created successfully.',
            'errors' => null,
        ], 201);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $authId = request()->get('uid');
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
        $authId = request()->get('uid');
        $this->postService->deletePost($id, $authId);
        return response()->json(['message' => 'Post deleted successfully.'], 204);
    }

    public function like($id)
    {
        $authId = request()->get('uid');
        $like = $this->postService->likePost($id, $authId);
        return response()->json(['data' => $like, 'message' => 'Post liked successfully.'], 201);
    }

    public function unlike($id)
    {
        $authId = request()->get('uid');
        $this->postService->unlikePost($id, $authId);
        return response()->json(['message' => 'Post unliked successfully.'], 204);
    }

    public function share($id)
    {
        $authId = request()->get('uid');
        $share = $this->postService->sharePost($id, $authId);
        return response()->json(['data' => $share, 'message' => 'Post shared successfully.'], 201);
    }

    public function privacies()
    {
        $privacies = $this->postService->getPrivacies();
        return response()->json(['data' => $privacies, 'message' => 'Privacies retrieved successfully.'], 200);
    }
}

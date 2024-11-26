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

class CommentController extends Controller
{
    public function __construct(
        protected GetPostsUseCase $getPostsUseCase,
        protected CreatePostUseCase $createPostUseCase,
        protected UpdatePostUseCase $updatePostUseCase,
        protected ViewPostUseCase $viewPostUseCase,
        protected DeletePostUseCase $deletePostUseCase,
    ) {}

    public function addCommentToAPost($id)
    {
        $authId = request()->get('uid');
        $post = 'share_usecase';
        return response()->json(['data' => $post, 'message' => 'Post shared successfully.'], 201);
    }

    public function updatePostComment($id)
    {
        $authId = request()->get('uid');
        $post = 'share_usecase';
        return response()->json(['data' => $post, 'message' => 'Post shared successfully.'], 201);
    }

    public function removeAPostComment($id)
    {
        $authId = request()->get('uid');
        $post = 'share_usecase';
        return response()->json(['data' => $post, 'message' => 'Post shared successfully.'], 201);
    }

    public function getPostComments($id)
    {
        $authId = request()->get('uid');
        $post = 'share_usecase';
        return response()->json(['data' => $post, 'message' => 'Post shared successfully.'], 201);
    }
}

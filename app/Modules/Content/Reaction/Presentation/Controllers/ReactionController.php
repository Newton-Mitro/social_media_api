<?php

namespace App\Modules\Content\Reaction\Presentation\Controllers;

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

class ReactionController extends Controller
{
    public function __construct(
        protected GetPostsUseCase $getPostsUseCase,
        protected CreatePostUseCase $createPostUseCase,
        protected UpdatePostUseCase $updatePostUseCase,
        protected ViewPostUseCase $viewPostUseCase,
        protected DeletePostUseCase $deletePostUseCase,
    ) {}

    public function reactToPost($id)
    {
        $authId = request()->get('uid');
        $post = 'unlike_usecase';
        return response()->json(['data' => $post, 'message' => 'Successfully reacted to a post.'], 204);
    }
}

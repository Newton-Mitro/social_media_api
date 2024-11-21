<?php

namespace App\Modules\Content\Post\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Post\Application\UseCases\GetPostsUseCase;
use Illuminate\Http\Request;

class GetPostsController extends Controller
{
    public function __construct(protected GetPostsUseCase $fetchPostsUseCase) {}

    public function __invoke(Request $request)
    {

        $authId = request()->get('uid');
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        $posts =  $this->fetchPostsUseCase->handle(
            limit: $limit,
            offset: $offset,
            auth_user_id: $authId
        );


        return response()->json([
            'data' => $posts,
            'message' => 'Fetch posts successfully.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

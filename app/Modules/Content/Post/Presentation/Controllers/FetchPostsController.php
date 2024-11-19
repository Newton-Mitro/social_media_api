<?php

namespace App\Modules\Content\Post\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Post\Application\UseCases\FetchPostsUseCase;
use Illuminate\Http\Request;

class FetchPostsController extends Controller
{
    public function __construct(protected FetchPostsUseCase $fetchPostsUseCase) {}

    public function __invoke(Request $request)
    {

        $authId = request()->get('uid');
        $limit = $request->input('per_page', 10);
        $offset = $request->input('per_page', 10);

        $this->fetchPostsUseCase->handle(
            limit: $limit,
            offset: $offset,
            auth_user_id: $authId
        );


        return response()->json([
            'data' => null,
            'message' => 'Fetch posts successfully.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

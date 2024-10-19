<?php

namespace App\Modules\Post\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Post\Mappers\PostMapper;
use App\Modules\Post\UseCases\Queries\GetUserPosts\GetUserPostsQuery;
use Symfony\Component\HttpFoundation\Response;

class GetPostController extends Controller
{
    public function __construct() {}

    public function __invoke(int $user_id)
    {
        $startRecord = request()->filled('start_record') ? request()->query('start_record') : 1;
        $pageSize = request()->filled('page_size') ? request()->query('page_size') : 4;
        $posts = $this->queryBus->ask(
            new GetUserPostsQuery(
                userId: $user_id,
                startRecord: $startRecord,
                pageSize: $pageSize
            )
        );
        $postResources = PostMapper::toPostResourceArray($posts);

        return response()->json([
            'data' => $postResources,
            'message' => 'success',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }

    public function get_all_posts(int $user_id)
    {
        $startRecord = request()->filled('start_record') ? request()->query('start_record') : 1;
        $pageSize = request()->filled('page_size') ? request()->query('page_size') : 4;
        $posts = $this->queryBus->ask(
            new GetUserPostsQuery(
                userId: $user_id,
                startRecord: $startRecord,
                pageSize: $pageSize
            )
        );
        $postResources = PostMapper::toPostResourceArray($posts);

        return response()->json([
            'data' => $postResources,
            'message' => 'success',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}

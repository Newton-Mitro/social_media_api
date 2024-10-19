<?php

namespace App\Features\Post\Controllers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Core\Controllers\Controller;
use App\Features\Post\Mappers\PostMapper;
use App\Features\Post\UseCases\Queries\GetUserPosts\GetUserPostsQuery;
use Symfony\Component\HttpFoundation\Response;

class GetPostController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus   $queryBus,
    ) {}

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

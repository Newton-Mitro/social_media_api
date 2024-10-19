<?php

namespace App\Modules\Post\UseCases\Queries\GetUserPosts;

use App\Modules\Post\Interfaces\PostRepositoryInterface;

class GetUserPostsQueryHandler
{
    public function __construct(
        protected PostRepositoryInterface $repository,
    ) {}

    public function handle(GetUserPostsQuery $command): array
    {

        $res = $this->repository->getPostsByUser($command->getUserId(), $command->getStartRecord(), $command->getPageSize());

        return $res;
    }
}

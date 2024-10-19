<?php

namespace App\Features\Post\UseCases\Queries\GetUserPosts;

use App\Core\Bus\CommandHandler;
use App\Features\Post\Interfaces\PostRepositoryInterface;

class GetUserPostsQueryHandler extends CommandHandler
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

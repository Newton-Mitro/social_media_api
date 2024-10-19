<?php

namespace App\Modules\Post\UseCases\Queries\FindPost;

use App\Modules\Post\Interfaces\PostRepositoryInterface;
use App\Modules\Post\UseCases\Queries\FindPost\FindPostByPostIdQuery;

class FindPostByPostIdQueryHandler
{
    public function __construct(
        protected PostRepositoryInterface $repository,
    ) {}

    public function handle(FindPostByPostIdQuery $query): ?object
    {
        // return $this->repository->findPostByPostId(
        //     $query->getPostId(),
        // );
        return null;
    }
}

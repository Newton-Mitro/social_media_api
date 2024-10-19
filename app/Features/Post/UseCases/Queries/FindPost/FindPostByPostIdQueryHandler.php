<?php
namespace App\Features\Post\UseCases\Queries\FindPost;
use App\Core\Bus\QueryHandler;
use App\Features\Post\Interfaces\PostRepositoryInterface;
use App\Features\Post\UseCases\Queries\FindPost\FindPostByPostIdQuery;

class FindPostByPostIdQueryHandler extends QueryHandler
{
    public function __construct(
        protected PostRepositoryInterface $repository,
    ) {
    }

    public function handle(FindPostByPostIdQuery $query): ?object
    {
        // return $this->repository->findPostByPostId(
        //     $query->getPostId(),
        // );
        return null;
    }
}
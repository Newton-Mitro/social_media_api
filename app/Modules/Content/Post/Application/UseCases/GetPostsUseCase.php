<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Content\Post\Application\Mappers\PostAggregateMapper;
use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;

class GetPostsUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(int $limit = 10, int $offset = 0, $auth_user_id = null)
    {
        $posts = $this->postRepository->getPosts($limit, $offset, $auth_user_id);
        return PostAggregateMapper::toDTOCollection($posts);
    }
}

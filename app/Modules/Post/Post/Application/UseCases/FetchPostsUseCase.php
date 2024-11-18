<?php

namespace App\Modules\Post\Application\UseCases;

use App\Modules\Post\Domain\Interfaces\PostRepositoryInterface;

class FetchPostsUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(int $limit = 10, int $offset = 0, $auth_user_id = null)
    {

        return $this->postRepository->getAll($limit, $offset, $auth_user_id);
    }
}

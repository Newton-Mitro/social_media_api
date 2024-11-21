<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;


class CreatePostUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(): void
    {
        // User Exist

        // Create Post Aggregate

        // Persist Post Aggregate (DB Transaction)
    }
}

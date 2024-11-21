<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;


class AddCommentUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(): void
    {
        // Get Post Aggregate

        // Update Comment Count

        // Create Comment Entity

        // Persist Post Aggregate and Comment (DB transaction)
    }
}

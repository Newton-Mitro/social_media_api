<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;

class RemoveCommentUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(): void
    {
        // User Exist

        // Post Exist

        // Update Comment Count

        // Create Comment Entity

        // Persist Post and Comment (DB transaction)
    }
}

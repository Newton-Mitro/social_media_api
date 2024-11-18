<?php

namespace App\Modules\Post\Application\UseCases;

use App\Modules\Post\Domain\Interfaces\PostRepositoryInterface;

class PostReactionUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(): void {}
}

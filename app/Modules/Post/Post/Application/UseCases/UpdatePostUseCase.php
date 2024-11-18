<?php

namespace App\Modules\Post\Application\UseCases;

use App\Modules\Post\Domain\Interfaces\PostRepositoryInterface;

class UpdatePostUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(): void {}
}

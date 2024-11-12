<?php

namespace App\Modules\Post\Application\UseCases;

use App\Modules\Post\Domain\Interfaces\PostRepositoryInterface;

class DeletePostUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(): void {}
}

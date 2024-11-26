<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeletePostUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle(string $postId): void
    {
        $post =  $this->postRepository->findById($postId);
        if (!$post) {
            throw new NotFoundHttpException('Post not found');
        }
        $this->postRepository->deleteById($postId);
    }
}

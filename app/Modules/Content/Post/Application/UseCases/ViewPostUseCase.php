<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Content\Post\Application\Mappers\PostAggregateMapper;
use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use Exception;
use Illuminate\Http\Response;

class ViewPostUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function handle($id)
    {
        $post = $this->postRepository->findById($id);

        if (!$post) {
            throw new Exception("Attachment not found.", Response::HTTP_NOT_FOUND);
        }

        return PostAggregateMapper::toDTO($post);
    }
}

<?php

namespace App\Features\Post\Interfaces;

use App\Features\Post\Models\Post;
use App\Features\Post\BusinessModels\PostModel;
use App\Features\Post\UseCases\Commands\UpdatePost\UpdatePostCommand;

interface PostRepositoryInterface
{
    public function create(PostModel $postModel): string;
    public function getPostsByUser(int $userId, int $startRec, int $pageSize): array;
    public function update(PostModel $postModel): string;
}
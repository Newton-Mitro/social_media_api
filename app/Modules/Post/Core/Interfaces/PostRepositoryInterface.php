<?php

namespace App\Modules\Post\Interfaces;

use App\Modules\Post\Models\Post;
use App\Modules\Post\BusinessModels\PostModel;
use App\Modules\Post\UseCases\Commands\UpdatePost\UpdatePostCommand;

interface PostRepositoryInterface
{
    public function create(PostModel $postModel): string;
    public function getPostsByUser(int $userId, int $startRec, int $pageSize): array;
    public function update(PostModel $postModel): string;
}

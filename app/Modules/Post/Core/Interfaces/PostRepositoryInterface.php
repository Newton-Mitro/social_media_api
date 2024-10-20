<?php

namespace App\Modules\Post\Core\Interfaces;

use App\Modules\Post\Core\Entities\PostModel;


interface PostRepositoryInterface
{
    public function create(PostModel $postModel): string;
    public function getPostsByUser(int $userId, int $startRec, int $pageSize): array;
    public function update(PostModel $postModel): string;
}

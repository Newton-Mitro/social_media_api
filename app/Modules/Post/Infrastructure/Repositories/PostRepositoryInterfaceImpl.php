<?php

namespace App\Modules\Post\Infrastructure\Repositories;

use App\Modules\Post\Core\Entities\PostModel;
use App\Modules\Post\Core\Interfaces\PostRepositoryInterface;



class PostRepositoryInterfaceImpl implements PostRepositoryInterface
{
    public function create(PostModel $postModel): string
    {
        return '';
    }

    public function getPostsByUser(int $userId, int $startRec, int $pageSize): array
    {
        return [];
    }

    public function update(PostModel $postModel): string
    {
        return '';
    }
}

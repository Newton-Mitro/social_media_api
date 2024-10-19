<?php

namespace App\Features\Post\UseCases\Queries\GetUserPosts;

use App\Core\Bus\Query;

class GetUserPostsQuery extends Query
{
    public function __construct(
        private readonly int $userId,
        private readonly int $startRecord,
        private readonly int $pageSize,
    )
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStartRecord(): int
    {
        return $this->startRecord;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}

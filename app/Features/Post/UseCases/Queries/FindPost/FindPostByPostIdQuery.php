<?php
namespace App\Features\Post\UseCases\Queries\FindPost;

use App\Core\Bus\Query;

class FindPostByPostIdQuery extends Query
{
    public function __construct(
        private readonly int $postId

    ) {
    }

    /**
     * Get the value of postId
     */
    public function getPostId()
    {
        return $this->postId;
    }
}
<?php

namespace App\Modules\Content\Comment\Domain\Repositories;

use Illuminate\Support\Collection;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Comment\Domain\Entities\CommentEntity;

interface CommentRepositoryInterface
{
    public function addComment(PostAggregate $post, CommentEntity $comment): void;
    public function removeComment(PostAggregate $post, CommentEntity $comment): void;
    public function updateComment(PostAggregate $post, CommentEntity $comment): void;
    public function saveComments(PostAggregate $post, Collection $comments): void;
}

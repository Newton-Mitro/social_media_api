<?php

namespace App\Modules\Post\Core\Interfaces;

use App\Modules\Post\Domain\Entities\CommentEntity;
use App\Modules\Post\Domain\Entities\PostAggregate;
use Illuminate\Support\Collection;

interface CommentRepositoryInterface
{
    public function addComment(PostAggregate $post, CommentEntity $comment): void;
    public function removeComment(PostAggregate $post, CommentEntity $comment): void;
    public function updateComment(PostAggregate $post, CommentEntity $comment): void;
    public function saveComments(PostAggregate $post, Collection $comments): void;
}

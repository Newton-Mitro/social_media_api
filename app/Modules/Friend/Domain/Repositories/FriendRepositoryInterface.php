<?php

namespace App\Modules\Friend\Domain\Repositories;

use App\Modules\Post\Domain\Entities\CommentEntity;
use App\Modules\Post\Domain\Entities\PostAggregate;
use Illuminate\Support\Collection;

interface FriendRepositoryInterface
{
    public function addComment(PostAggregate $post, CommentEntity $comment): void;
    public function removeComment(PostAggregate $post, CommentEntity $comment): void;
    public function updateComment(PostAggregate $post, CommentEntity $comment): void;
    public function saveComments(PostAggregate $post, Collection $comments): void;
}

<?php

namespace App\Modules\Post\Domain\Interfaces;

use App\Modules\Post\Domain\Entities\PostAggregate;
use App\Modules\Post\Domain\Entities\ReactionEntity;

interface ReactionRepositoryInterface
{
    public function addReact(PostAggregate $post, ReactionEntity $reaction);
    public function updateReact(PostAggregate $post, ReactionEntity $reaction);
    public function removeReact(PostAggregate $post, ReactionEntity $reaction);
}

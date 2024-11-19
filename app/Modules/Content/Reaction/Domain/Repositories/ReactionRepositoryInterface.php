<?php

namespace App\Modules\Content\Reaction\Domain\Repositories;

use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Reaction\Domain\Entities\ReactionEntity;


interface ReactionRepositoryInterface
{
    public function addReact(PostAggregate $post, ReactionEntity $reaction);
    public function updateReact(PostAggregate $post, ReactionEntity $reaction);
    public function removeReact(PostAggregate $post, ReactionEntity $reaction);
}

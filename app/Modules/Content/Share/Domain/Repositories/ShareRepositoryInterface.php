<?php

namespace App\Modules\Content\Share\Domain\Repositories;

use App\Modules\Content\Share\Domain\Entities\ShareEntity;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;


interface ShareRepositoryInterface
{
    public function addShare(PostAggregate $post, ShareEntity $share);
    public function removeShare(PostAggregate $post, ShareEntity $share);
}

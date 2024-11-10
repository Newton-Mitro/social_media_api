<?php

namespace App\Modules\Post\Domain\Interfaces;

use App\Modules\Post\Domain\Entities\PostAggregate;
use App\Modules\Post\Domain\Entities\ShareEntity;

interface ShareRepositoryInterface
{
    public function addShare(PostAggregate $post, ShareEntity $share);
    public function removeShare(PostAggregate $post, ShareEntity $share);
}

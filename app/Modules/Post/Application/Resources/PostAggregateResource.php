<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Application\Resources\UserResource;
use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Post\Application\Resources\PostResource;
use App\Modules\Post\Domain\Entities\ReactionEntity;
use Illuminate\Support\Collection;

class PostAggregateResource
{
    public function __construct(
        public PostResource $post,
        public PrivacyResource $privacy,
        public UserResource $creator,
        public Collection $attachments,
        public Collection $comments,
        public Collection $reactions,
        public ?ReactionResource $myReaction,
        public Collection $views,
        public int $viewCount,
        public Collection $shares,
        public int $shareCount,
        public bool $active,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt
    ) {}
}

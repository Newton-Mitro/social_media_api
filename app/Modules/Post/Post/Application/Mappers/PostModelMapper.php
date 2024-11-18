<?php

namespace App\Modules\Post\Application\Mappers;

use App\Modules\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Post\Domain\Enums\PostStatus;
use App\Modules\Post\Infrastructure\Models\Post;

class PostModelMapper
{
    public static function fromModel(Post $model): PostAggregate
    {
        return new PostAggregate(
            id: $model->id,
            content: $model->content,
            creator: null, // Fetch UserEntity based on $model->creator_id
            privacy: null, // Fetch PrivacyEntity based on $model->privacy_id
            reactionCount: $model->reaction_count,
            viewCount: $model->view_count,
            shareCount: $model->share_count,
            commentCount: $model->comment_count,
            status: PostStatus::from($model->status),
            createdAt: $model->created_at,
            updatedAt: $model->updated_at
        );
    }

    public static function toModel(PostAggregate $aggregate): Post
    {
        return new Post([
            'id' => $aggregate->getId(),
            'content' => $aggregate->getContent(),
            'creator_id' => $aggregate->getCreator()?->getId(),
            'privacy_id' => $aggregate->getPrivacy()?->getId(),
            'reaction_count' => $aggregate->getReactionCount(),
            'view_count' => $aggregate->getViewCount(),
            'share_count' => $aggregate->getShareCount(),
            'comment_count' => $aggregate->getCommentCount(),
            'status' => $aggregate->getStatus()->value,
            'created_at' => $aggregate->getCreatedAt(),
            'updated_at' => $aggregate->getUpdatedAt()
        ]);
    }
}

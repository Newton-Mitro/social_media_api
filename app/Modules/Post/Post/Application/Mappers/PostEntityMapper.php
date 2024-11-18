<?php

namespace App\Modules\Post\Application\Mappers;

use App\Modules\Post\Domain\Aggregates\PostAggregate;

class PostEntityMapper
{
    public static function fromAggregate(PostAggregate $aggregate): PostEntity
    {
        return new PostEntity(
            id: $aggregate->getId(),
            content: $aggregate->getContent(),
            creatorId: $aggregate->getCreator()?->getId(),
            privacyId: $aggregate->getPrivacy()?->getId(),
            reactionCount: $aggregate->getReactionCount(),
            viewCount: $aggregate->getViewCount(),
            shareCount: $aggregate->getShareCount(),
            commentCount: $aggregate->getCommentCount(),
            status: $aggregate->getStatus()->value,
            createdAt: $aggregate->getCreatedAt(),
            updatedAt: $aggregate->getUpdatedAt()
        );
    }

    public static function toAggregate(PostEntity $entity): PostAggregate
    {
        return new PostAggregate(
            id: $entity->id,
            content: $entity->content,
            creator: null, // Replace with UserEntity fetched from the database
            privacy: null, // Replace with PrivacyEntity fetched from the database
            reactionCount: $entity->reactionCount,
            viewCount: $entity->viewCount,
            shareCount: $entity->shareCount,
            commentCount: $entity->commentCount,
            status: PostStatus::from($entity->status),
            createdAt: $entity->createdAt,
            updatedAt: $entity->updatedAt
        );
    }
}

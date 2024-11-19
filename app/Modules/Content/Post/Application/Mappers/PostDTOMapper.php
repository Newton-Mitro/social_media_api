<?php

namespace App\Modules\Content\Post\Application\Mappers;

use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;


class PostDTOMapper
{
    public static function fromAggregate(PostAggregate $aggregate): PostDTO
    {
        return new PostDTO(
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
            updatedAt: $aggregate->getUpdatedAt(),
            attachments: $aggregate->getAttachments()->map(fn($attachment) => $attachment->toDTO())->toArray()
        );
    }

    public static function toAggregate(PostDTO $dto): PostAggregate
    {
        // You can fetch related entities here (like UserEntity and PrivacyEntity)
        return new PostAggregate(
            id: $dto->id,
            content: $dto->content,
            creator: null, // Replace with a UserEntity instance fetched from a repository
            privacy: null, // Replace with a PrivacyEntity instance fetched from a repository
            reactionCount: $dto->reactionCount,
            viewCount: $dto->viewCount,
            shareCount: $dto->shareCount,
            commentCount: $dto->commentCount,
            status: PostStatus::from($dto->status),
            createdAt: $dto->createdAt,
            updatedAt: $dto->updatedAt
        );
    }
}

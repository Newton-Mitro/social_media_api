<?php

namespace App\Modules\Content\Post\Application\Mappers;

use App\Modules\Auth\Application\Mappers\UserMapper;
use App\Modules\Content\Attachment\Application\Mappers\AttachmentMapper;
use App\Modules\Content\Post\Application\DTOs\PostAggregateDTO;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Privacy\Application\Mappers\PrivacyMapper;
use App\Modules\Content\Reaction\Application\Mappers\ReactionMapper;

class PostAggregateMapper
{
    public static function toDTO(PostAggregate $aggregate): PostAggregateDTO
    {
        $postAggregateDTO = new PostAggregateDTO(
            id: $aggregate->getId(),
            content: $aggregate->getContent(),
            creator: UserMapper::toDTO($aggregate->getCreator()),
            privacy: PrivacyMapper::toDTO($aggregate->getPrivacy()),
            my_reaction: ReactionMapper::toDTO($aggregate->getMyReaction()),
            reaction_count: $aggregate->getReactionCount(),
            view_count: $aggregate->getViewCount(),
            share_count: $aggregate->getShareCount(),
            comment_count: $aggregate->getCommentCount(),
            status: $aggregate->getStatus()->value,
            created_at: $aggregate->getCreatedAt(),
            updated_at: $aggregate->getUpdatedAt(),
        );

        $attachments = AttachmentMapper::toDTOCollection($aggregate->getAttachments());

        $postAggregateDTO->attachments = $attachments;

        return $postAggregateDTO;
    }
}

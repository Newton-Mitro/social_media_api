<?php

namespace App\Modules\Content\Post\Infrastructure\Mappers;

use App\Modules\Auth\Infrastructure\Mappers\UserAggregateMapper;
use App\Modules\Content\Attachment\Infrastructure\Mappers\AttachmentMapper;
use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Post\Domain\ValueObjects\PostStatus;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Privacy\Infrastructure\Mappers\PrivacyMapper;
use App\Modules\Content\Reaction\Infrastructure\Mappers\ReactionMapper;
use Illuminate\Support\Collection;

class PostAggregateMapper
{
    public static function toEntity(Post $post): PostAggregate
    {
        $privacy = PrivacyMapper::toEntity($post->privacy);
        $creator = UserAggregateMapper::toAggregate($post->creator);

        $myReaction = $post->myReaction ? ReactionMapper::toEntity($post->myReaction) : null;

        $postAggregate = new PostAggregate(
            id: $post->id,
            content: $post->post_text,
            privacy: $privacy,
            creator: $creator,
            myReaction: $myReaction,
            commentCount: $post->comment_count,
            reactionCount: $post->reaction_count,
            viewCount: $post->view_count,
            shareCount: $post->share_count,
            status: PostStatus::tryFrom($post->status),
            createdAt: new \DateTimeImmutable($post->created_at),
            updatedAt: new \DateTimeImmutable($post->updated_at),
        );

        $post->attachments->map(function (Attachment $attachment) use ($postAggregate) {
            $postAggregate->addAttachment(AttachmentMapper::toEntity($attachment));
        });

        return $postAggregate;
    }

    public static function toEntityCollection(Collection $posts): Collection
    {
        return $posts->map(fn(Post $post) => self::toEntity($post));
    }

    public static function toModel(PostAggregate $postAggregate): Post
    {
        $post = new Post([
            'id' => $postAggregate->getId(),
            'content' => $postAggregate->getContent(),
            'privacy_id' => $postAggregate->getPrivacy()->getId(),
            'creator_id' => $postAggregate->getCreator()->getId(),
            'comment_count' => $postAggregate->getCommentCount(),
            'reaction_count' => $postAggregate->getReactionCount(),
            'view_count' => $postAggregate->getViewCount(),
            'share_count' => $postAggregate->getShareCount(),
            'status' => $postAggregate->getStatus(),
            'created_at' => $postAggregate->getCreatedAt(),
            'updated_at' => $postAggregate->getUpdatedAt(),
        ]);

        $postAggregate->getAttachments()->map(function ($attachmentEntity) use ($post) {
            $attachmentModel = AttachmentMapper::toModel($attachmentEntity);
            $post->attachments()->save($attachmentModel);
        });

        return $post;
    }
}

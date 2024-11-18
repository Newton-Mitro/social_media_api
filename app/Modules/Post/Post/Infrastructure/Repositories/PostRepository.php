<?php

namespace App\Modules\Post\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Entities\UserEntity;
use App\Modules\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Post\Domain\Entities\AttachmentEntity;
use App\Modules\Post\Domain\Entities\CommentEntity;
use App\Modules\Post\Domain\Enums\ReactionTypes;
use App\Modules\Post\Domain\Interfaces\PostRepositoryInterface;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Repositories\CommentRepository;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function save(PostAggregate $post): void
    {
        DB::transaction(function () use ($post) {
            $eloquentPost = Post::find($post->getId()) ?? new Post();
            $eloquentPost->content = $post->getContent();
            $eloquentPost->save();
        });
    }

    public function findById(string $postId): ?PostAggregate
    {
        $eloquentPost = Post::with('comments, attachments, reactions, views, shares')->find($postId);
        if (!$eloquentPost) return null;

        $post = new PostAggregate(
            id: $eloquentPost->id,
            content: $eloquentPost->content,
            privacy: $eloquentPost->privacy,
            creator: $eloquentPost->createdBy,
            status: $eloquentPost->status,
            createdAt: $eloquentPost->createdAt,
            updatedAt: $eloquentPost->updatedAt,
        );
        foreach ($eloquentPost->attachments as $eloquentAttachment) {
            $comment = new AttachmentEntity(
                id: $eloquentAttachment->id,
                postId: $eloquentAttachment->postId,
                description: $eloquentAttachment->content
            );
            $post->addComment($comment);
        }

        return $post;
    }

    public function deleteById(string $postId): void
    {
        DB::transaction(function () use ($postId) {
            // delete post comments
            // delete post reactions
            // delete post shares
            // delete post views
            // delete post attachments
            Post::destroy($postId);
        });
    }


    public function addComment(PostAggregate $post, CommentEntity $comment): void
    {
        DB::transaction(function () use ($post, $comment) {
            $eloquentPost = Post::find($post->getId());

            if ($eloquentPost) {
                $this->commentRepository->addComment($eloquentPost, $comment);
            }
        });
    }

    public function removeComment(PostAggregate $post, CommentEntity $comment): void
    {
        DB::transaction(function () use ($post, $comment) {
            $eloquentPost = Post::find($post->getId());

            if ($eloquentPost) {
                $this->commentRepository->removeComment($eloquentPost, $comment);
            }
        });
    }

    public function updateComment(PostAggregate $post, CommentEntity $comment): void
    {
        DB::transaction(function () use ($post, $comment) {
            $eloquentPost = Post::find($post->getId());

            if ($eloquentPost) {
                $this->commentRepository->updateComment($eloquentPost, $comment);
            }
        });
    }

    public function getAll(int $limit = 10, int $offset = 0, ?string $auth_user_id = null): array
    {
        $posts = Post::with(['comments', 'reactions', 'attachments'])
            ->limit($limit)
            ->offset($offset)
            ->get();

        return $posts->map(fn($post) => $this->mapToAggregate($post))->toArray();
    }

    private function mapToAggregate(Post $post): PostAggregate
    {

        return new PostAggregate(
            id: $post->id,
            content: $post->content,
            privacy: $post->privacy,
            createdBy: $post->user,
            active: $post->active,
            createdAt: $post->created_at,
            updatedAt: $post->updated_at,
            comments: new Collection($post->comments),
            attachments: new Collection($post->attachments),
            reactions: $post->reactions->count()
        );
    }



    public function delete(string $postId): void {}

    public function reactToPost(PostAggregate $postId, UserEntity $userId, ReactionTypes $reactionType) {}

    public function getReactions() {}

    public function sharePost(PostAggregate $postId, UserEntity $userId) {}
    public function getShares() {}

    public function viewPost(PostAggregate $postId, UserEntity $userId) {}
    public function getViews() {}

    public function saveComment() {}
    public function deleteComment() {}
    public function getComments() {}
}

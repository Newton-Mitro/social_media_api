<?php

namespace App\Modules\Post\Infrastructure\Repositories;

use App\Modules\Post\Domain\Entities\CommentEntity;
use App\Modules\Post\Domain\Entities\PostAggregate;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Repositories\CommentRepository;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;



class PostRepository
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
            privacyId: $eloquentPost->privacyId,
            createdBy: $eloquentPost->createdBy,
            active: $eloquentPost->active,
            createdAt: $eloquentPost->createdAt,
            updatedAt: $eloquentPost->updatedAt,
        );
        foreach ($eloquentPost->comments as $eloquentComment) {
            $comment = new CommentEntity(
                id: $eloquentComment->id,
                postId: $eloquentComment->postId,
                authorId: $eloquentComment->authorId,
                content: $eloquentComment->content
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
}

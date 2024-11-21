<?php

namespace App\Modules\Content\Post\Infrastructure\Repositories;

use App\Modules\Content\Comment\Domain\Entities\CommentEntity;
use App\Modules\Content\Comment\Infrastructure\Repositories\CommentRepository;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Content\Post\Infrastructure\Mappers\PostAggregateMapper;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Reaction\Domain\Entities\ReactionEntity;
use App\Modules\Content\Share\Domain\Entities\ShareEntity;
use App\Modules\Content\View\Domain\Entities\ViewEntity;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{

    public function __construct(protected CommentRepository $commentRepository) {}

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
        $post = DB::table('posts')
            ->leftJoin('attachments', 'posts.id', '=', 'attachments.post_id')
            ->leftJoin('privacies', 'posts.privacy_id', '=', 'privacies.id')
            ->leftJoin('users as creators', 'posts.creator_id', '=', 'creators.id')
            ->leftJoin('reactions as myReaction', function ($join) {
                $join->on('posts.id', '=', 'myReaction.reactable_id')
                    ->where('myReaction.reactable_type', '=', 'post');
            })
            ->where('posts.id', '=', $postId)
            ->select('posts.*', 'privacies.*', 'creators.*', 'myReaction.*', 'attachments.*')
            ->first();

        if (!$post) {
            return null;
        }

        return PostAggregateMapper::toEntity($post);
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

    public function getPosts(int $limit = 10, int $offset = 0, ?string $auth_user_id = null): Collection
    {
        $posts = DB::table('posts')
            ->leftJoin('attachments', 'posts.id', '=', 'attachments.post_id')
            ->leftJoin('privacies', 'posts.privacy_id', '=', 'privacies.id')
            ->leftJoin('users as creators', 'posts.creator_id', '=', 'creators.id')
            ->leftJoin('reactions as myReaction', function ($join) use ($auth_user_id) {
                $join->on('posts.id', '=', 'myReaction.reactable_id')
                    ->where('myReaction.reactable_type', '=', 'post')
                    ->where('myReaction.user_id', '=', $auth_user_id);
            })
            ->select('posts.*', 'privacies.*', 'creators.*', 'myReaction.*', 'attachments.*') // Adjust based on actual columns
            ->limit($limit)
            ->offset($offset)
            ->get();

        return PostAggregateMapper::toEntityCollection($posts);
    }

    public function getUserPosts(int $limit = 10, int $offset = 0, ?string $auth_user_id): Collection
    {
        $posts = DB::table('posts')
            ->leftJoin('attachments', 'posts.id', '=', 'attachments.post_id')
            ->leftJoin('privacies', 'posts.privacy_id', '=', 'privacies.id')
            ->leftJoin('users as creators', 'posts.creator_id', '=', 'creators.id')
            ->leftJoin('reactions as myReaction', function ($join) use ($auth_user_id) {
                $join->on('posts.id', '=', 'myReaction.reactable_id')
                    ->where('myReaction.reactable_type', '=', 'post')
                    ->where('myReaction.user_id', '=', $auth_user_id);
            })
            ->select('posts.*', 'privacies.*', 'creators.*', 'myReaction.*', 'attachments.*') // Adjust based on actual columns
            ->limit($limit)
            ->offset($offset)
            ->get();

        return PostAggregateMapper::toEntityCollection($posts);
    }

    public function delete(string $postId): void {}

    public function reactToPost(PostAggregate $postAggregate, ReactionEntity $reactionEntity) {}
    public function getPostReactions(string $post_id) {}

    public function sharePost(PostAggregate $postAggregate, ShareEntity $shareEntity) {}
    public function getPostShares(string $post_id) {}

    public function viewPost(PostAggregate $postAggregate, ViewEntity $viewEntity) {}
    public function getPostViews(string $post_id) {}

    public function addPostComment(PostAggregate $postAggregate, CommentEntity $commentEntity) {}
    public function getPostComments(string $post_id) {}
}

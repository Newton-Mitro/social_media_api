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
        $post = Post::with([
            'attachments',
            'privacy:id,name', // Include only relevant columns from privacies
            'creator:id,name,email', // Include relevant user columns
            'reactions' => function ($query) {
                $query->where('reactable_type', 'post');
            }
        ])
            ->find($postId);

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

    public function getPosts(int $limit = 10, int $offset = 0, ?string $authUserId = null): Collection
    {
        $postsQuery = Post::with([
            'attachments',
            'privacy',
            'creator',
        ])
            ->whereHas('privacy', function ($query) {
                // Fetch only posts with a 'Public' privacy level
                $query->where('privacy_name', 'Public'); // Adjust column name if necessary
            })
            ->latest('created_at'); // Order by the latest posts

        if ($authUserId) {
            // Include the user's reaction if `authUserId` is provided
            $postsQuery->with(['myReaction' => function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            }]);
        }

        // Fetch posts with pagination
        $posts = $postsQuery
            ->skip($offset)
            ->take($limit)
            ->get();

        return PostAggregateMapper::toEntityCollection($posts);
    }


    public function getUserPosts(int $limit = 10, int $offset = 0, string $userId, ?string $authUserId = null): Collection
    {
        $postsQuery = Post::with([
            'attachments',
            'privacy',
            'creator',
        ])
            ->latest('created_at'); // Order by the latest posts

        if ($authUserId && $userId === $authUserId) {
            // Fetch all posts for the authenticated user
            $postsQuery->where('creator_id', $userId);
        } else {
            // Fetch only public posts for other users
            $postsQuery->where('creator_id', $userId)
                ->whereHas('privacy', function ($query) {
                    $query->where('privacy_name', 'Public'); // Adjust column name if necessary
                });
        }

        if ($authUserId) {
            // Include the authenticated user's reaction
            $postsQuery->with(['myReaction' => function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            }]);
        }

        // Fetch posts with pagination
        $posts = $postsQuery
            ->skip($offset)
            ->take($limit)
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

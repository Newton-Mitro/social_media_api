<?php

namespace App\Modules\Content\Post\Infrastructure\Repositories;

use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use App\Modules\Content\Comment\Domain\Entities\CommentEntity;
use App\Modules\Content\Comment\Infrastructure\Repositories\CommentRepository;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Content\Post\Infrastructure\Mappers\PostAggregateMapper;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Reaction\Domain\Entities\ReactionEntity;
use App\Modules\Content\Share\Domain\Entities\ShareEntity;
use App\Modules\Content\View\Domain\Entities\ViewEntity;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostRepository implements PostRepositoryInterface
{

    public function __construct(protected CommentRepository $commentRepository) {}

    public function save(PostAggregate $postAggregate): void
    {
        DB::transaction(function () use ($postAggregate) {
            // Save Post
            $post = Post::create([
                'id' => $postAggregate->getId(),
                'post_text' => $postAggregate->getPostText(),
                'privacy_id' => $postAggregate->getPrivacy()->getId(),
                'user_id' => $postAggregate->getCreator()->getId(),
                'created_at' => $postAggregate->getCreatedAt(),
                'updated_at' => $postAggregate->getUpdatedAt(),
            ]);

            // Save Attachments
            foreach ($postAggregate->getAttachments() as $attachment) {
                Attachment::create([
                    'id' => $attachment->getId(),
                    'post_id' => $post->id,
                    'file_name' => $attachment->getFileName(),
                    'file_path' => $attachment->getFilePath(),
                    'file_url'  => $attachment->getFileURL(),
                    'mime_type' => $attachment->getMimeType(),
                    'thumbnail_url' => $attachment->getThumbnailURL(),
                    'duration' => $attachment->getDuration(),
                ]);
            }
        });
    }

    public function update(PostAggregate $postAggregate): void
    {
        DB::transaction(function () use ($postAggregate) {
            $post = Post::findOrFail($postAggregate->getId());

            // Update Post
            $post->update([
                'post_text' => $postAggregate->getPostText(),
                'privacy_id' => $postAggregate->getPrivacy()->getId(),
                'updated_at' => $postAggregate->getUpdatedAt(),
            ]);

            // Get current attachment IDs from the aggregate
            $updatedAttachmentIds = $postAggregate->getAttachments()->pluck('id')->toArray();

            // Get current attachments in the database
            $existingAttachments = Attachment::where('post_id', $post->id)->get();

            // Identify and delete attachments that are no longer in the aggregate
            $existingAttachments->each(function ($existingAttachment) use ($updatedAttachmentIds) {
                if (!in_array($existingAttachment->id, $updatedAttachmentIds)) {
                    $existingAttachment->delete();
                }
            });


            // Update Attachments
            foreach ($postAggregate->getAttachments() as $attachment) {
                Attachment::updateOrCreate(
                    ['id' => $attachment->getId()],
                    [
                        'post_id' => $post->id,
                        'file_name' => $attachment->getFileName(),
                        'file_path' => $attachment->getFilePath(),
                        'file_url'  => $attachment->getFileURL(),
                        'mime_type' => $attachment->getMimeType(),
                        'thumbnail_url' => $attachment->getThumbnailURL(),
                        'duration' => $attachment->getDuration(),
                    ]
                );
            }
        });
    }


    public function deleteById(string $postId): void
    {
        try {
            DB::transaction(function () use ($postId) {
                $post = Post::findOrFail($postId);

                // Delete attachments
                foreach ($post->attachments as $attachment) {
                    Storage::disk('public')->delete($attachment->file_path);
                    $attachment->delete();
                }
                // delete post comments
                foreach ($post->comments as $comment) {
                    $comment->delete();
                }
                // delete post reactions
                foreach ($post->reactions as $reaction) {
                    $reaction->delete();
                }
                // delete post shares
                foreach ($post->shares as $share) {
                    $share->delete();
                }
                // delete post views
                // foreach ($post->views as $view) {
                //     $view->delete();
                // }
                // delete post
                $post->delete();
            });
        } catch (Exception $ex) {
            throw new Exception("Database error.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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

    public function findById(string $postId): ?PostAggregate
    {
        $post = Post::with([
            'attachments',
            'privacy',
            'creator',
            'myReaction'
        ])
            ->find($postId);

        if (!$post) {
            return null;
        }

        return PostAggregateMapper::toEntity($post);
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

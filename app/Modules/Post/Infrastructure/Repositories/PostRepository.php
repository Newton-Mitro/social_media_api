<?php

namespace App\Modules\Post\Infrastructure\Repositories;

use App\Modules\Post\Core\Interfaces\PostRepositoryInterface;
use App\Modules\Post\Infrastructure\Models\Post;



class PostRepository implements PostRepositoryInterface
{
    public function getPostsWithRelations($perPage, $userId = null)
    {
        $query = Post::with(['user', 'privacy', 'attachments'])
            ->where(function ($query) use ($userId) {
                $query->where('privacy_id', 1);

                if ($userId) {
                    $query->orWhereHas('user', function ($subQuery) use ($userId) {
                        $subQuery->whereIn('id', function ($friendQuery) use ($userId) {
                            $friendQuery->select('friend_id')
                                ->from('friends')
                                ->where('user_id', $userId);
                        });
                    });
                }
            });

        return $query->latest()
            ->paginate($perPage)
            ->through(function ($post) use ($userId) {
                // Determine if the post is liked by the user
                $likes = $post->likes();
                $post->isLiked = $userId ? $post->likes()->where('user_id', $userId)->exists() : false;
                return $post;
            });
    }


    public function findByIdWithRelations($id, $userId = null)
    {
        $post = Post::with(['user', 'privacy', 'attachments'])->findOrFail($id);

        // Determine if the post is liked by the user
        $post->isLiked = $userId ? $post->likes()->where('user_id', $userId)->exists() : false;

        return $post;
    }

    public function create(array $data, $userId = null)
    {
        // Create the post with the provided data
        $post = Post::create($data);

        // Check if there are attachments and associate them with the post
        if (isset($data['attachments'])) {
            $post->attachments()->createMany($data['attachments']);
        }

        // Load user, privacy, and attachments relationships
        $post->load(['user', 'privacy', 'attachments']);

        // Determine if the post is liked by the user
        $post->isLiked = $userId ? $post->likes()->where('user_id', $userId)->exists() : false;

        return $post;
    }

    public function update($id, array $data, $userId = null)
    {
        // Find the post by ID or fail
        $post = Post::findOrFail($id);

        // Update the post's attributes
        $post->update([
            'body' => $data['body'],
            'location' => $data['location'],
            'privacy_id' => $data['privacy_id'],
        ]);

        // Handle attachments
        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachmentData) {
                if (isset($attachmentData['id'])) {
                    // Update existing attachment
                    $attachment = $post->attachments()->findOrFail($attachmentData['id']);
                    $attachment->update($attachmentData);
                } else {
                    // Create new attachment
                    $post->attachments()->create($attachmentData);
                }
            }
        }

        // Load user, privacy, and attachments relationships after update
        $post->load(['user', 'privacy', 'attachments']);

        // Determine if the post is liked by the user
        $post->isLiked = $userId ? $post->likes()->where('user_id', $userId)->exists() : false;

        return $post;
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->attachments()->delete();
        $post->delete();
    }

    public function like($id, $userId)
    {
        $post = Post::findOrFail($id);
        $like = $post->likes()->create(['user_id' => $userId]);
        $post->increment('likes');
        return $like;
    }

    public function unlike($id, $userId)
    {
        $post = Post::findOrFail($id);
        $like = $post->likes()->where('user_id', $userId)->first();
        if ($like) {
            $like->delete();
            $post->decrement('likes');
        }
    }

    public function share($id, $userId)
    {
        $post = Post::findOrFail($id);
        $share = $post->shares()->create(['user_id' => $userId]);
        $post->increment('shares');
        return $share;
    }
}

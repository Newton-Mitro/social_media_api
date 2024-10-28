<?php

namespace App\Modules\Post\Infrastructure\Repositories;

use App\Modules\Post\Core\Interfaces\PostRepositoryInterface;
use App\Modules\Post\Infrastructure\Models\Post;



class PostRepository implements PostRepositoryInterface
{
    public function getPostsWithRelations($perPage, $userId = null)
    {
        return Post::with(['user', 'privacy', 'attachments'])
            ->where(function ($query) use ($userId) {
                $query->where('privacy_id', 1);
                if ($userId) {
                    $query->orWhereHas('user', function ($query) use ($userId) {
                        $query->whereIn('id', function ($subQuery) use ($userId) {
                            $subQuery->select('friend_id')
                                ->from('friends')
                                ->where('user_id', $userId);
                        });
                    });
                }
            })
            ->latest()
            ->paginate($perPage);
    }

    public function findByIdWithRelations($id)
    {
        return Post::with(['user', 'privacy', 'attachments'])->findOrFail($id);
    }

    public function create(array $data)
    {
        $post = Post::create($data);
        if (isset($data['attachments'])) {
            $post->attachments()->createMany($data['attachments']);
        }

        // Load user, privacy, and attachments relationships
        $post->load(['user', 'privacy', 'attachments']);

        return $post;
    }

    public function update($id, array $data)
    {
        $post = Post::findOrFail($id);
        $post->body = $data['body'];
        $post->location = $data['location'];
        $post->privacy_id = $data['privacy_id'];
        $post->save();

        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachmentData) {
                if (isset($attachmentData['id'])) {
                    $attachment = $post->attachments()->findOrFail($attachmentData['id']);
                    $attachment->update($attachmentData);
                } else {
                    $post->attachments()->create($attachmentData);
                }
            }
        }

        // Load user, privacy, and attachments relationships
        $post->load(['user', 'privacy', 'attachments']);

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

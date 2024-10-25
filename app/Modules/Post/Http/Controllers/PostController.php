<?php

namespace App\Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Attachment;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Set a default number of posts per page
        $posts = Post::with(['user', 'comments', 'attachments'])
            ->latest()
            ->paginate($perPage);

        // Check if each post is liked by the current user
        $posts->getCollection()->transform(function ($post) {
            $post->is_liked = $post->likes()->where('user_id', Auth::id())->exists();
            return $post;
        });

        return response()->json([
            'data' => $posts,
            'message' => 'Posts retrieved successfully.',
            'errors' => null,
        ], 200);
    }

    public function show($id)
    {
        $post = Post::with(['user', 'comments', 'attachments'])->findOrFail($id);
        $post->is_liked = $post->likes()->where('user_id', Auth::id())->exists();

        return response()->json([
            'data' => $post,
            'message' => 'Post retrieved successfully.',
            'errors' => null,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'location' => 'nullable|string',
            'privacy_id' => 'required|exists:privacies,id',
            'attachments.*.type' => 'required|in:image,video,link,document',
            'attachments.*.url' => 'required|url',
            'attachments.*.thumbnail_url' => 'nullable|url',
            'attachments.*.description' => 'nullable|string',
            'attachments.*.duration' => 'nullable|integer',
        ]);

        $user = request()->get('user');

        $post = Post::create([
            'body' => $request->body,
            'location' => $request->location,
            'privacy_id' => $request->privacy_id,
            'user_id' =>  $user['user_id'],
        ]);

        // Handle attachments
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachmentData) {
                $post->attachments()->create($attachmentData);
            }
        }

        return response()->json([
            'data' => $post,
            'message' => 'Post created successfully.',
            'errors' => null,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'body' => 'sometimes|required|string',
            'location' => 'sometimes|nullable|string',
            'privacy_id' => 'sometimes|required|exists:privacies,id',
            'attachments.*.id' => 'nullable|exists:attachments,id',
            'attachments.*.type' => 'nullable|in:image,video,link,document',
            'attachments.*.url' => 'nullable|url',
            'attachments.*.thumbnail_url' => 'nullable|url',
            'attachments.*.description' => 'nullable|string',
            'attachments.*.duration' => 'nullable|integer',
            'deleted_attachments.*' => 'nullable|exists:attachments,id',
        ]);

        // Update post properties
        $post->update($request->only('body', 'location', 'privacy_id'));

        // Handle existing attachments
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachmentData) {
                if (isset($attachmentData['id'])) {
                    // Update existing attachment
                    $attachment = Attachment::findOrFail($attachmentData['id']);
                    $attachment->update($attachmentData);
                } else {
                    // Create new attachment
                    $post->attachments()->create($attachmentData);
                }
            }
        }

        // Handle deletions
        if ($request->has('deleted_attachments')) {
            foreach ($request->deleted_attachments as $attachmentId) {
                $attachment = Attachment::findOrFail($attachmentId);
                $attachment->delete();
            }
        }

        return response()->json([
            'data' => $post,
            'message' => 'Post updated successfully.',
            'errors' => null,
        ], 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->attachments()->delete(); // Delete attachments before deleting the post
        $post->delete();

        return response()->json([
            'data' => null,
            'message' => 'Post deleted successfully.',
            'errors' => null,
        ], 204);
    }

    public function like($id)
    {
        $post = Post::findOrFail($id);
        $like = $post->likes()->create(['user_id' => Auth::id()]);
        $post->increment('likes');

        return response()->json([
            'data' => $like,
            'message' => 'Post liked successfully.',
            'errors' => null,
        ], 201);
    }

    public function unlike($id)
    {
        $post = Post::findOrFail($id);
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            $post->decrement('likes');
        }

        return response()->json([
            'data' => null,
            'message' => 'Post unliked successfully.',
            'errors' => null,
        ], 204);
    }

    public function share($id)
    {
        $post = Post::findOrFail($id);
        $share = $post->shares()->create(['user_id' => Auth::id()]);
        $post->increment('shares');

        return response()->json([
            'data' => $share,
            'message' => 'Post shared successfully.',
            'errors' => null,
        ], 201);
    }
}

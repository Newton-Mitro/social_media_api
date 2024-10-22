<?php

namespace App\Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Attachment;

class PostControllerTemp extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $posts = Post::with(['user', 'comments', 'attachments'])
            ->latest()
            ->paginate($perPage);

        $posts->transform(function ($post) {
            $post->isLiked = $post->likes()->where('user_id', Auth::id())->exists();
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
        $post->isLiked = $post->likes()->where('user_id', Auth::id())->exists();

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
            'attachments.*' => 'file|mimes:jpeg,png,gif,mp4,mp3,doc,pdf|max:2048',
        ]);

        $post = Post::create([
            'body' => $request->body,
            'location' => $request->location,
            'privacy_id' => $request->privacy_id,
            'user_id' => Auth::id(),
        ]);

        $this->handleAttachments($request, $post);

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
            'attachments.*' => 'file|mimes:jpeg,png,gif,mp4,mp3,doc,pdf|max:2048',
        ]);

        $post->update($request->only('body', 'location', 'privacy_id'));

        // Handle attachments
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachmentData) {
                if (isset($attachmentData['id'])) {
                    // Update existing attachment
                    $attachment = Attachment::findOrFail($attachmentData['id']);

                    // If file is uploaded, update the file
                    if (isset($attachmentData['file'])) {
                        // Delete the old file
                        Storage::disk('public')->delete($attachment->url);
                        // Store the new file
                        $path = $attachmentData['file']->store('uploads', 'public');
                        $attachmentData['url'] = $path; // Update the URL in the array
                    }

                    $attachment->update($attachmentData);
                } else {
                    // Create new attachment
                    $this->handleNewAttachment($attachmentData, $post);
                }
            }
        }

        return response()->json([
            'data' => $post,
            'message' => 'Post updated successfully.',
            'errors' => null,
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->attachments()->each(function ($attachment) {
            Storage::disk('public')->delete($attachment->url); // Delete the file
        });
        $post->attachments()->delete(); // Delete attachment records
        $post->delete();

        return response()->json([
            'data' => null,
            'message' => 'Post deleted successfully.',
            'errors' => null,
        ], 204);
    }

    protected function handleAttachments(Request $request, Post $post)
    {
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->handleNewAttachment($file, $post);
            }
        }
    }

    protected function handleNewAttachment($file, Post $post)
    {
        $path = $file->store('uploads', 'public');
        $post->attachments()->create([
            'url' => $path,
            'type' => $file->getClientOriginalExtension(),
        ]);
    }

    public function like(Request $request, $id)
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

    // Add methods for comments as needed
}

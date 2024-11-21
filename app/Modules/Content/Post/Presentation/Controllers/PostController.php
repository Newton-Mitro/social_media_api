<?php

namespace App\Modules\Content\Post\Presentation\Controllers;

use Illuminate\Http\Request;
use App\Core\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Post\Infrastructure\Models\Attachment;
use App\Modules\Content\Post\Presentation\Requests\StorePostRequest;
use App\Modules\Content\Post\Presentation\Requests\UpdatePostRequest;

class PostController extends Controller
{

    public function __construct() {}

    public function index(Request $request)
    {
        $authId = request()->get('uid');
        $perPage = $request->input('per_page', 10);
        $posts = 'usecase';

        return response()->json(['data' => $posts, 'message' => 'Posts retrieved successfully.'], 200);
    }

    public function show($id)
    {
        $authId = request()->get('uid');
        $post = 'usecase';
        return response()->json(['data' => $post, 'message' => 'Post retrieved successfully.'], 200);
    }

    public function store(StorePostRequest $request)
    {
        $authId = request()->get('uid');
        $data = $request->validated();
        $post = 'usecase';

        return response()->json([
            'data' => $post,
            'message' => 'Post created successfully.',
            'errors' => null,
        ], 201);
    }

    public function store_v2(Request $request)
    {
        $authId = request()->get('uid');
        $request->validate([
            'body' => 'required|string',
            'location' => 'nullable|string',
            'privacy_id' => 'required|exists:privacies,id',
            'attachments.*' => [
                'file',
                'mimes:jpeg,png,gif,mp4,mp3,doc,pdf',
                function ($attribute, $value, $fail) {
                    // Define maximum size for each file type (in KB)
                    $maxSizes = [
                        'image' => 1024,     // 1 MB for images
                        'video' => 10240,    // 10 MB for videos
                        'document' => 1024,  // 1 MB for documents
                        'audio' => 3072      // 3 MB for audio
                    ];

                    // Determine the file type
                    $mimeType = $value->getMimeType();
                    $fileSize = $value->getSize() / 1024; // Convert file size to KB

                    // Check if it's an image
                    if (str_contains($mimeType, 'image') && $fileSize > $maxSizes['image']) {
                        return $fail("The {$attribute} image must not be greater than {$maxSizes['image']} KB.");
                    }

                    // Check if it's a video
                    if (str_contains($mimeType, 'video') && $fileSize > $maxSizes['video']) {
                        return $fail("The {$attribute} video must not be greater than {$maxSizes['video']} KB.");
                    }

                    // Check if it's a document (PDF, doc)
                    if ((str_contains($mimeType, 'pdf') || str_contains($mimeType, 'msword')) && $fileSize > $maxSizes['document']) {
                        return $fail("The {$attribute} document must not be greater than {$maxSizes['document']} KB.");
                    }

                    // Check if it's an audio file (mp3)
                    if (str_contains($mimeType, 'audio') && $fileSize > $maxSizes['audio']) {
                        return $fail("The {$attribute} audio must not be greater than {$maxSizes['audio']} KB.");
                    }
                },
            ],
        ]);

        $post = Post::create([
            'body' => $request->body,
            'location' => $request->location,
            'privacy_id' => $request->privacy_id,
            'user_id' => $authId,
        ]);

        $this->handleAttachments($request, $post);

        // Load user, privacy, and attachments relationships
        $post->load(['user', 'privacy', 'attachments']);

        // Determine if the post is liked by the user
        $post->isLiked = false;

        return response()->json([
            'data' => $post,
            'message' => 'Post created successfully.',
            'errors' => null,
        ], 201);
    }

    public function update_v2(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'body' => 'sometimes|required|string',
            'location' => 'sometimes|nullable|string',
            'privacy_id' => 'sometimes|required|exists:privacies,id',
            'attachments.*.id' => 'nullable|exists:attachments,id',
            'attachments.*' => [
                'file',
                'mimes:jpeg,png,gif,mp4,mp3,doc,pdf',
                function ($attribute, $value, $fail) {
                    // Define maximum size for each file type (in KB)
                    $maxSizes = [
                        'image' => 1024,    // 1 MB for images
                        'video' => 10240,   // 10 MB for videos
                        'document' => 1024, // 1 MB for documents
                        'audio' => 3072     // 3 MB for audio
                    ];

                    // Determine the file type
                    $mimeType = $value->getMimeType();
                    $fileSize = $value->getSize() / 1024; // Convert file size to KB

                    // Check if it's an image
                    if (str_contains($mimeType, 'image') && $fileSize > $maxSizes['image']) {
                        return $fail("The {$attribute} image must not be greater than {$maxSizes['image']} KB.");
                    }

                    // Check if it's a video
                    if (str_contains($mimeType, 'video') && $fileSize > $maxSizes['video']) {
                        return $fail("The {$attribute} video must not be greater than {$maxSizes['video']} KB.");
                    }

                    // Check if it's a document (PDF, doc)
                    if ((str_contains($mimeType, 'pdf') || str_contains($mimeType, 'msword')) && $fileSize > $maxSizes['document']) {
                        return $fail("The {$attribute} document must not be greater than {$maxSizes['document']} KB.");
                    }

                    // Check if it's an audio file (mp3)
                    if (str_contains($mimeType, 'audio') && $fileSize > $maxSizes['audio']) {
                        return $fail("The {$attribute} audio must not be greater than {$maxSizes['audio']} KB.");
                    }
                },
            ],
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

    public function destroy_v2($id)
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
            'file_name' => basename($path),
            'url' => asset(Storage::url($path)),
            'thumbnail_url' => asset(Storage::url($path)),
            'type' => $file->getMimeType(),
            'path' => $path,
        ]);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $authId = request()->get('uid');
        $data = $request->validated();
        $post = 'usecase';

        return response()->json([
            'data' => $post,
            'message' => 'Post updated successfully.',
            'errors' => null,
        ], 200);
    }

    public function destroy($id)
    {
        $authId = request()->get('uid');

        return response()->json(['message' => 'Post deleted successfully.'], 204);
    }

    public function like($id)
    {
        $authId = request()->get('uid');
        $post = 'usecase';
        return response()->json(['data' => $post, 'message' => 'Post liked successfully.'], 201);
    }

    public function unlike($id)
    {
        $authId = request()->get('uid');
        $post = 'usecase';
        return response()->json(['data' => $post, 'message' => 'Post unliked successfully.'], 204);
    }

    public function share($id)
    {
        $authId = request()->get('uid');
        $post = 'usecase';
        return response()->json(['data' => $post, 'message' => 'Post shared successfully.'], 201);
    }
}
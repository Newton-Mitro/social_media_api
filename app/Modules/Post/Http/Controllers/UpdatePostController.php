<?php

namespace App\Modules\Post\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Post\Models\Post;
use App\Modules\Post\Requests\UpdatePostRequest;
use App\Modules\Post\UseCases\Commands\UpdatePost\UpdatePostCommand;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UpdatePostController extends Controller
{
    public function __construct() {}

    public function __invoke(UpdatePostRequest $request)
    {
        $attachments = [];
        // dd($request);
        $existingPosts = Post::with("postdetails")->find($request->post_id);
        // dd($existingPosts);
        if ($request->hasFile('attachments')) {

            $files = $request->file('attachments');
            foreach ($files as $file) {

                $contentType = $file->getMimeType();
                if (explode('/', $contentType)[0] == 'image') {
                    $basePath = 'posts/images/';
                    $storagePath = $file->store($basePath, 'public');
                    $attachments[] = [
                        'content_url' => asset('storage/' . $basePath),
                        'content_name' => basename($storagePath),
                        'content_type' => $contentType
                    ];
                } else if (explode('/', $contentType)[0] == 'video') {
                    $basePath = 'posts/videos/';
                    $storagePath = $file->store($basePath, 'public');
                    $attachments[] = [
                        'content_url' => asset('storage/' . $basePath),
                        'content_name' => basename($storagePath),
                        'content_type' => $contentType
                    ];
                }
            }
        }


        $post = $this->commandBus->dispatch(
            new UpdatePostCommand(
                postId: $request->post_id,
                userId: $request->user['user_id'],
                body: $request->body,
                existing_content_url: $request->existing_content_url,
                privacyId: $request->privacy_id,
                attachments: $attachments
            ),
        );

        if ($post == "Success") {
            // dd($existingPosts->postdetails[0]);
            foreach ($existingPosts->postdetails as $value) {
                // dd($value->content_url.'/'. $value->content_name);
                // Delete Old Photo
                if (explode('/', $value->content_type)[0] == 'image') {
                    $basePath = 'posts/images/';
                    Storage::disk('public')->delete($basePath . '/' . $value->content_name);
                    // @unlink($value->content_url.'/'. $value->content_name);
                } else if (explode('/', $value->content_type)[0] == 'video') {
                    $basePath = 'posts/videos/';
                    Storage::disk('public')->delete($basePath . '/' . $value->content_name);
                }
            }
        }


        return response()->json([
            'data' => $post,
            'message' => 'Post has updated Successfully.',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}

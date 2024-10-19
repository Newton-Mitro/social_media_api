<?php

namespace App\Features\Post\Controllers;

use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Core\Controllers\Controller;
use App\Features\Post\Models\Post;
use App\Features\Post\Requests\RemovePostRequest;
use App\Features\Post\UseCases\Commands\RemovePost\RemovePostCommand;
use App\Features\Post\UseCases\Commands\UpdatePost\UpdatePostCommand;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class RemovePostController extends Controller
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {}

    public function __invoke(RemovePostRequest $request)
    {
        $attachments = [];
        $existingPosts = Post::with("postdetails")->find($request->post_id);
        
        

        $post = $this->commandBus->dispatch(
            new RemovePostCommand(
                postId: $request->post_id,
                postModel: $existingPosts
            ),
        );
        //############ Remove portion commented out for decision ##############

        // if ($post == "Success") {
        //     // dd($existingPosts->postdetails[0]);
        //     foreach ($existingPosts->postdetails as $value) {
        //         // dd($value->content_url.'/'. $value->content_name);
        //         // Delete Old Photo
        //         if (explode('/', $value->content_type)[0] == 'image') {
        //             $basePath = 'posts/images/';
        //             Storage::disk('public')->delete($basePath.'/'. $value->content_name);
        //             // @unlink($value->content_url.'/'. $value->content_name);
        //         }else if (explode('/', $value->content_type)[0] == 'video') {
        //             $basePath = 'posts/videos/';
        //             Storage::disk('public')->delete($basePath.'/'. $value->content_name);
        //         }
        //     }
        // }
        //############ Remove portion commented out for decision ##############

        return response()->json([
            'data' => $post,
            'message' => 'Post has been removed successfully.',
            'errors' => null,
        ], Response::HTTP_CREATED);
    }
}

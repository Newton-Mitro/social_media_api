<?php

namespace App\Modules\Content\Reaction\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Post\Application\UseCases\CreatePostUseCase;
use App\Modules\Content\Post\Application\UseCases\DeletePostUseCase;
use App\Modules\Content\Post\Application\UseCases\GetPostsUseCase;
use App\Modules\Content\Post\Application\UseCases\UpdatePostUseCase;
use App\Modules\Content\Post\Application\UseCases\ViewPostUseCase;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Reaction\Infrastructure\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReactionController extends Controller
{
    public function __construct(
        protected GetPostsUseCase $getPostsUseCase,
        protected CreatePostUseCase $createPostUseCase,
        protected UpdatePostUseCase $updatePostUseCase,
        protected ViewPostUseCase $viewPostUseCase,
        protected DeletePostUseCase $deletePostUseCase,
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reactable_id' => 'required|uuid',
            'type' => ['required', Rule::in(['Like', 'Love', 'Haha', 'Wow', 'Sad', 'Angry'])],
        ]);

        $userId = $request->user()->id;

        // Ensure the post exists before reacting
        if (!Post::where('id', $validated['reactable_id'])->exists()) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Check if the user has already reacted to this post
        $reaction = Reaction::where([
            'user_id' => $userId,
            'reactable_id' => $validated['reactable_id'],
        ])->first();

        if ($reaction) {
            // Update the existing reaction
            $reaction->update(['type' => $validated['type']]);
        } else {
            // Create a new reaction
            $reaction = Reaction::create([
                'user_id' => $userId,
                'reactable_id' => $validated['reactable_id'],
                'type' => $validated['type'],
            ]);
        }

        return response()->json(['message' => 'Reaction added successfully', 'reaction' => $reaction], 201);
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'reactable_id' => 'required|uuid',
        ]);

        $userId = $request->user()->id;

        $deleted = Reaction::where([
            'user_id' => $userId,
            'reactable_id' => $validated['reactable_id'],
        ])->delete();

        if ($deleted) {
            return response()->json(['message' => 'Reaction removed successfully']);
        }

        return response()->json(['message' => 'No reaction found'], 404);
    }
}

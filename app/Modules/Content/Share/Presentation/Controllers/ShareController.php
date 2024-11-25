<?php

namespace App\Modules\Content\Share\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Share\Infrastructure\Models\Share;
use App\Modules\Friend\Infrastructure\Models\FriendRequest;
use Illuminate\Http\Request;


class ShareController extends Controller
{
    public function share(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'nullable|exists:posts,id',
            'attachment_id' => 'nullable|exists:attachments,id',
            'shared_to' => 'required|exists:users,id',
            'message' => 'nullable|string|max:255',
        ]);

        if (!$validated['post_id'] && !$validated['attachment_id']) {
            return response()->json(['error' => 'You must share a post or an attachment.'], 400);
        }

        // Validate attachment belongs to post if both are provided
        if ($validated['post_id'] && $validated['attachment_id']) {
            $attachmentBelongsToPost = Attachment::where('id', $validated['attachment_id'])
                ->where('post_id', $validated['post_id'])
                ->exists();
            if (!$attachmentBelongsToPost) {
                return response()->json(['error' => 'Attachment does not belong to the post.'], 400);
            }
        }

        $share = Share::create([
            'post_id' => $validated['post_id'],
            'attachment_id' => $validated['attachment_id'],
            'shared_by' => auth()->id(),
            'shared_to' => $validated['shared_to'],
            'message' => $validated['message'] ?? '',
        ]);

        return response()->json(['message' => 'Shared successfully.', 'share' => $share], 201);
    }

    public function getSharesByUser($userId)
    {
        $shares = Share::with(['post', 'attachment'])
            ->where('shared_to', $userId)
            ->get();

        return response()->json(['shares' => $shares]);
    }

    public function getHomePageShares($userId)
    {
        $shares = Share::with(['post.user', 'attachment', 'sharedBy'])
            ->where('shared_to', $userId)
            ->latest()
            ->get();

        return $shares;
    }

    public function getHomePagePosts($userId)
    {
        $friendsIds = FriendRequest::where('user_id', $userId)
            ->orWhere('friend_id', $userId)
            ->whereNotNull('accepted_at') // Ensure friendship is accepted
            ->pluck('friend_id');

        $posts = Post::with(['user', 'attachments', 'shares.sharedBy'])
            ->whereIn('user_id', $friendsIds->push($userId)) // Include the user's posts
            ->latest() // Show recent posts first
            ->get();

        return $posts;
    }

    public function getHomePageFeed($userId)
    {
        // Fetch posts
        $posts = $this->getHomePagePosts($userId);

        // Fetch shares
        $shares = $this->getHomePageShares($userId);

        // Combine posts and shares into a unified feed
        $feed = collect($posts)->merge($shares)->sortByDesc('created_at');

        return response()->json($feed->values());
    }
}


// [
//     {
//         "id": "post1",
//         "type": "post",
//         "content": "User's post content",
//         "user": {
//             "id": "user1",
//             "name": "John Doe"
//         },
//         "attachments": [
//             {
//                 "id": "attachment1",
//                 "file_name": "image.jpg"
//             }
//         ],
//         "shares": []
//     },
//     {
//         "id": "share1",
//         "type": "share",
//         "post": {
//             "id": "post2",
//             "content": "Friend's post content",
//             "user": {
//                 "id": "friend1",
//                 "name": "Jane Smith"
//             }
//         },
//         "attachment": null,
//         "shared_by": {
//             "id": "user2",
//             "name": "Mark Johnson"
//         },
//         "shared_to": {
//             "id": "user1",
//             "name": "John Doe"
//         }
//     }
// ]

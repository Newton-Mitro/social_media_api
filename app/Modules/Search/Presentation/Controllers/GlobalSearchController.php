<?php

namespace App\Modules\Search\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class GlobalSearchController extends Controller
{
    public function __construct() {}

    public function __invoke(Request $request)
    {
        $searchKeyword = $request->input('q');

        // Validate the search keyword
        if (empty($searchKeyword)) {
            return response()->json([
                'data' => [],
                'message' => 'No search keyword provided.',
                'errors' => ['keyword' => 'The search keyword is required.'],
            ], Response::HTTP_BAD_REQUEST);
        }

        // Fetch users based on the search keyword
        $results = User::with(['profile', 'posts' => function ($query) use ($searchKeyword) {
            $query->where('post_text', 'like', '%' . $searchKeyword . '%')
                ->with(['creator.profile', 'privacy', 'attachments']);
        }])
            ->where(function ($query) use ($searchKeyword) {
                $query->where('name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('email', 'like', '%' . $searchKeyword . '%')
                    ->orWhereHas('posts', function ($query) use ($searchKeyword) {
                        $query->where('post_text', 'like', '%' . $searchKeyword . '%');
                    });
            })
            ->get()
            ->map(function ($user) {
                // Fetch additional counts for followers, following, friends, sent requests, and pending requests for each searched user
                $user->followers_count = DB::table('follows')
                    ->where('following_id', $user->id)
                    ->count();

                $user->following_count = DB::table('follows')
                    ->where('follower_id', $user->id)
                    ->count();

                $user->friends_count = DB::table('friend_requests')
                    ->where(function ($query) use ($user) {
                        $query->where('sender_id', $user->id)
                            ->orWhere('receiver_id', $user->id);
                    })
                    ->where('status', 'accepted')
                    ->count();

                $user->friend_requests_count = DB::table('friend_requests')
                    ->where('receiver_id', $user->id)
                    ->where('status', 'pending')
                    ->count();

                $user->post_likes_count = DB::table('posts')
                    ->where('user_id', $user->id)
                    ->sum('reaction_count');

                // Add a custom flag to check if the current user is following the searched user (example placeholder for "is_following" logic)
                $user->is_following = false; // Add actual logic to check if current user is following the searched user

                // Add additional user info (is_user_profile, friend_request_status, etc.)
                $user->is_user_profile = true; // This can be adjusted based on your context, e.g., checking if this user is the current authenticated user
                $user->friend_request_status = null; // Add logic to return the current friend request status if exists

                // Return the user with the necessary post and profile structure
                return [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'account_verified' => $user->account_verified,
                        'profile' => [
                            'id' => $user->profile->id,
                            'user_id' => $user->profile->user_id,
                            'sex' => $user->profile->sex,
                            'dbo' => $user->profile->dbo,
                            'mobile_number' => $user->profile->mobile_number,
                            'profile_picture' => $user->profile->profile_picture,
                            'cover_photo' => $user->profile->cover_photo,
                            'bio' => $user->profile->bio,
                            'created_at' => $user->profile->created_at,
                            'updated_at' => $user->profile->updated_at,
                        ],
                    ],
                    'posts' => $user->posts->map(function ($post) {
                        return [
                            'id' => $post->id,
                            'postText' => $post->post_text,
                            'creator' => [
                                'id' => $post->creator->id,
                                'name' => $post->creator->name,
                                'email' => $post->creator->email,
                                'account_verified' => $post->creator->account_verified,
                                'profile' => [
                                    'id' => $post->creator->profile->id,
                                    'user_id' => $post->creator->profile->user_id,
                                    'sex' => $post->creator->profile->sex,
                                    'dbo' => $post->creator->profile->dbo,
                                    'mobile_number' => $post->creator->profile->mobile_number,
                                    'profile_picture' => $post->creator->profile->profile_picture,
                                    'cover_photo' => $post->creator->profile->cover_photo,
                                    'bio' => $post->creator->profile->bio,
                                    'created_at' => $post->creator->profile->created_at,
                                    'updated_at' => $post->creator->profile->updated_at,
                                ]
                            ],
                            'privacy' => [
                                'id' => $post->privacy->id,
                                'privacy_name' => $post->privacy->privacy_name,
                                'created_at' => $post->privacy->created_at,
                                'updated_at' => $post->privacy->updated_at,
                            ],
                            'my_reaction' => null,  // Add logic for user reaction here
                            'reaction_count' => $post->reaction_count,
                            'view_count' => $post->view_count,
                            'share_count' => $post->share_count,
                            'comment_count' => $post->comment_count,
                            'status' => $post->status,
                            'created_at' => $post->created_at,
                            'updated_at' => $post->updated_at,
                            'attachments' => $post->attachments->map(function ($attachment) {
                                return [
                                    'id' => $attachment->id,
                                    'post_id' => $attachment->post_id,
                                    'file_url' => $attachment->file_url,
                                    'thumbnail_url' => $attachment->thumbnail_url,
                                    'mime_type' => $attachment->mime_type,
                                    'file_name' => $attachment->file_name,
                                    'file_path' => $attachment->file_path,
                                    'title' => $attachment->title,
                                    'description' => $attachment->description,
                                    'duration' => $attachment->duration,
                                    'reaction_count' => $attachment->reaction_count,
                                    'view_count' => $attachment->view_count,
                                    'share_count' => $attachment->share_count,
                                    'comment_count' => $attachment->comment_count,
                                    'created_at' => $attachment->created_at,
                                    'updated_at' => $attachment->updated_at,
                                ];
                            })
                        ];
                    }),
                    'followers_count' => $user->followers_count,
                    'following_count' => $user->following_count,
                    'friends_count' => $user->friends_count,
                    'friend_requests_count' => $user->friend_requests_count,
                    'post_likes_count' => $user->post_likes_count,
                    'is_following' => $user->is_following,
                    'is_user_profile' => $user->is_user_profile,
                    'friend_request_status' => $user->friend_request_status,
                ];
            });

        return response()->json([
            'data' => $results,
            'message' => 'Search results fetched successfully.',
            'errors' => null,
        ], Response::HTTP_OK);
    }
}

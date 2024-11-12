<?php

namespace App\Modules\Follow\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Follow\Infrastructure\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $followerId = $request->get('uid');

        // Validate the request
        $request->validate([
            'following_id' => 'required|exists:users,id',
        ]);

        // Check if the follow record already exists to avoid duplication
        $existingFollow = Follow::where('follower_id', $followerId)
            ->where('following_id', $request->get('following_id'))
            ->first();

        if ($existingFollow) {
            return response()->json([
                'data' => null,
                'message' => 'Already following this user.',
                'error' => null,
                'errors' => null,
            ], 200);
        }

        // Create a new follow record
        Follow::create([
            'follower_id' => $followerId,
            'following_id' => $request->get('following_id'),
        ]);

        return response()->json([
            'data' => null,
            'message' => 'Followed successfully.',
            'error' => null,
            'errors' => null,
        ], 201);
    }

    public function unfollow(Request $request, $followingId)
    {
        $followerId = $request->get('uid');

        // Find the follow record and delete it
        $deleted = Follow::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->delete();

        if ($deleted) {
            return response()->json([
                'data' => null,
                'message' => 'Unfollowed successfully.',
                'error' => null,
                'errors' => null,
            ], 200);
        }

        return response()->json([
            'data' => null,
            'message' => 'Follow relationship not found.',
            'error' => null,
            'errors' => null,
        ], 404);
    }

    public function getFollowing(Request $request, $userId)
    {
        // Get the list of users the authenticated user is following
        $following = Follow::where('follower_id', $userId)
            ->with('following') // Ensure this relationship exists on the Follow model
            ->get()
            ->pluck('following');

        return response()->json([
            'data' => $following,
            'message' => 'Following list retrieved successfully.',
            'error' => null,
            'errors' => null,
        ]);
    }

    public function getFollowers(Request $request, $userId)
    {
        // Get the list of users that are following the authenticated user
        $followers = Follow::where('following_id', $userId)
            ->with('follower') // Ensure this relationship exists on the Follow model
            ->get()
            ->pluck('follower');

        return response()->json([
            'data' => $followers,
            'message' => 'Followers list retrieved successfully.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

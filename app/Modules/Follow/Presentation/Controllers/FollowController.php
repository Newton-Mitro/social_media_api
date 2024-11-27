<?php

namespace App\Modules\Follow\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Follow\Application\UseCases\FollowAUserUseCase;
use App\Modules\Follow\Application\UseCases\GetFollowersUseCase;
use App\Modules\Follow\Application\UseCases\GetFollowingUseCase;
use App\Modules\Follow\Application\UseCases\UnFollowAUserUseCase;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct(
        protected FollowAUserUseCase $followAUserUseCase,
        protected UnFollowAUserUseCase $unFollowAUserUseCase,
        protected GetFollowersUseCase $getFollowersUseCase,
        protected GetFollowingUseCase $getFollowingUseCase,
    ) {}

    public function follow(Request $request)
    {
        $followerId = $request->get('uid');

        // Validate the request
        $request->validate([
            'following_id' => 'required|exists:users,id',
        ]);

        $follow = $this->followAUserUseCase->handle($request->get('following_id'), $followerId);

        return response()->json([
            'data' => $follow,
            'message' => 'Followed successfully.',
            'error' => null,
            'errors' => null,
        ], 201);
    }

    public function unfollow(Request $request, $followingId)
    {
        $followerId = $request->get('uid');

        // Find the follow record and delete it
        $deleted =  $this->unFollowAUserUseCase->handle($followingId, $followerId);

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
        $following = $this->getFollowingUseCase->handle($userId);

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
        $followers = $this->getFollowersUseCase->handle($userId);

        return response()->json([
            'data' => $followers,
            'message' => 'Followers list retrieved successfully.',
            'error' => null,
            'errors' => null,
        ]);
    }
}

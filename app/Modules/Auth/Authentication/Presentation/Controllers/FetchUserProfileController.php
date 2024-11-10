<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Application\UseCases\FetchUserProfileUseCase;
use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FetchUserProfileController extends Controller
{
    public function __construct(protected readonly FetchUserProfileUseCase $fetchUserProfileUseCase) {}

    public function __invoke($userId)
    {
        // Fetch user profile with necessary relationships and counts
        $user = User::where('id', $userId)
            ->with([
                'userFollowers',          // Followers
                'userFollowing',          // Following
                'friends',                // Friends list
                'sentFriendRequests',     // Sent friend requests (pending)
                'pendingFriendRequests',  // Received friend requests (pending)
            ])
            ->withCount([
                'userFollowers as followers_count',
                'userFollowing as following_count',
                'friends as friends_count', // Count of friends
                'sentFriendRequests as sent_friend_requests_count', // Count of sent friend requests
                'pendingFriendRequests as pending_friend_requests_count', // Count of pending friend requests
                'posts as total_post_likes' => function ($query) {
                    $query->select(DB::raw('SUM(likes)'));
                },
            ])
            ->firstOrFail();

        $user->total_post_likes = (int) $user->total_post_likes;

        // Format the response
        return response()->json([
            'data' => $user,
            'message' => 'User Profile Fetched Successfully.',
            'errors' => null,
        ], Response::HTTP_OK);
    }
}

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
        $user = DB::table('users')
            ->where('id', $userId)
            ->select('users.*')
            ->first();

        if (!$user) {
            return response()->json([
                'data' => null,
                'message' => 'User not found.',
                'errors' => ['User not found.'],
            ], Response::HTTP_NOT_FOUND);
        }

        // Fetch followers, following, friends, sent friend requests, and pending friend requests
        $user->followers_count = DB::table('follows')
            ->where('following_id', $userId)
            ->count();

        $user->following_count = DB::table('follows')
            ->where('follower_id', $userId)
            ->count();

        $user->friends_count = DB::table('friends')
            ->where('user_id', $userId)
            ->orWhere('friend_id', $userId)
            ->count();

        $user->sent_friend_requests_count = DB::table('friend_requests')
            ->where('sender_id', $userId)
            ->where('status', 'pending')
            ->count();

        $user->pending_friend_requests_count = DB::table('friend_requests')
            ->where('receiver_id', $userId)
            ->where('status', 'pending')
            ->count();

        // Sum of likes on posts
        $user->total_post_likes = DB::table('posts')
            ->where('user_id', $userId)
            ->sum('likes');

        // Format the response
        return response()->json([
            'data' => $user,
            'message' => 'User Profile Fetched Successfully.',
            'errors' => null,
        ], Response::HTTP_OK);
    }
}

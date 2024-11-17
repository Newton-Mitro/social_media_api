<?php

namespace App\Modules\Profile\Infrastructure\Repositories;

use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Profile\Domain\Aggregates\ProfileAggregate;
use App\Modules\Profile\Domain\Interfaces\ProfileRepositoryInterface;
use App\Modules\Profile\Infrastructure\Models\Profile;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        // protected FollowRepositoryInterface $followRepository,
        // protected FriendRepositoryInterface $friendRepository,
        // protected PostRepositoryInterface $postRepository
    ) {}

    public function fetchUserProfile(string $userId, string $authUserId = null): ProfileAggregate
    {

        $user = $this->userRepository->findById(
            $userId
        );

        if (!$user) {
            throw new Exception('User not found.', Response::HTTP_NOT_FOUND);
        }

        $profile = Profile::where('user_id', $userId)->first();

        // Fetch followers, following, friends, sent friend requests, and pending friend requests
        $followers_count = DB::table('follows')
            ->where('following_id', $userId)
            ->count();

        $following_count = DB::table('follows')
            ->where('follower_id', $userId)
            ->count();

        $friends_count = DB::table('friend_requests')
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->where('status', 'accepted')
            ->count();

        $friend_requests_count = DB::table('friend_requests')
            ->where('receiver_id', $userId)
            ->where('status', 'pending')
            ->count();

        $post_likes_count = DB::table('posts')
            ->where('user_id', $userId)
            ->sum('reaction_count');

        $is_following = DB::table('follows')
            ->where('follower_id', $userId)
            ->where('following_id', $authUserId)
            ->exists();

        $friend_request_status = DB::table('friend_requests')
            ->where(function ($query) use ($userId, $authUserId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $authUserId);
            })
            ->orWhere(function ($query) use ($userId, $authUserId) {
                $query->where('sender_id', $authUserId)
                    ->where('receiver_id', $userId);
            })
            ->value('status');

        $is_user_profile = false;
        if ($authUserId) {
            $is_user_profile = $authUserId == $userId ? true : false;
        }

        return new ProfileAggregate(
            user: $user,
            profile: $profile,
            followers_count: $followers_count,
            following_count: $following_count,
            friends_count: $friends_count,
            friend_requests_count: $friend_requests_count,
            post_likes_count: $post_likes_count,
            is_following: $is_following,
            is_user_profile: $is_user_profile,
            friend_request_status: $friend_request_status
        );
    }
}

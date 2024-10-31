<?php

namespace App\Modules\Auth\User\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\User\Mappers\UserMapper;
use App\Modules\Auth\User\Models\User;
use App\Modules\Auth\User\UseCases\FetchUserProfileUseCase;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class FetchUserProfileController extends Controller
{
    public function __construct(protected readonly FetchUserProfileUseCase $fetchUserProfileUseCase) {}

    public function __invoke($userId)
    {
        // $user = $this->fetchUserProfileUseCase->handle($userId);

        $user = User::where('id', $userId)
            ->with(['userFollowers', 'userFollowing'])
            ->withCount(['userFollowers as followers_count', 'userFollowing as following_count'])
            ->withCount([
                'posts as total_post_likes' => function ($query) {
                    $query->select(DB::raw('SUM(likes)'));
                },
            ])
            ->firstOrFail();

        $user->total_post_likes = (int) $user->total_post_likes;

        return $user;
        // return response()->json([
        //     'data' => UserMapper::toUserResource($user),
        //     'message' => 'User Profile Fetched Successfully.',
        //     'errors' => null,
        // ], Response::HTTP_CREATED);
    }
}

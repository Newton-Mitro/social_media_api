<?php

namespace App\Modules\Auth\User\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\User\Mappers\UserMapper;
use App\Modules\Auth\User\Models\User;
use App\Modules\Auth\User\UseCases\FetchUserProfileUseCase;
use Symfony\Component\HttpFoundation\Response;

class FetchUserProfileController extends Controller
{
    public function __construct(protected readonly FetchUserProfileUseCase $fetchUserProfileUseCase) {}

    public function __invoke($userId)
    {
        // $user = $this->fetchUserProfileUseCase->handle($userId);

        $user = User::where('id', $userId)
            ->withCount(['followers', 'following'])
            ->firstOrFail();

        return $user;
        // return response()->json([
        //     'data' => UserMapper::toUserResource($user),
        //     'message' => 'User Profile Fetched Successfully.',
        //     'errors' => null,
        // ], Response::HTTP_CREATED);
    }
}

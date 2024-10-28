<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\User\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\User\Mappers\UserMapper;

class AuthUserController extends Controller
{
    public function __construct(protected readonly UserRepositoryInterface $userRepository) {}

    public function __invoke()
    {
        $authUser = request()->get('user');
        $user = $this->userRepository->findById($authUser['user_id']);

        return response()->json([
            'data' => UserMapper::toUserResource($user),
            'message' => null,
            'errors' => null,
        ]);
    }
}

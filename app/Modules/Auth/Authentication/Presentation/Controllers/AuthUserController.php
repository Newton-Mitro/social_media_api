<?php

namespace App\Modules\Auth\Authentication\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserMapper;

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

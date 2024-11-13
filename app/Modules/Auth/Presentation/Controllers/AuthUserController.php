<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\Mappers\UserResourceMapper;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;

class AuthUserController extends Controller
{
    public function __construct(protected readonly UserRepositoryInterface $userRepository) {}

    public function __invoke()
    {
        $authUser = request()->get('user');
        $user = $this->userRepository->findById($authUser['id']);

        return response()->json([
            'data' => UserResourceMapper::toResource($user),
            'message' => null,
            'errors' => null,
        ]);
    }
}
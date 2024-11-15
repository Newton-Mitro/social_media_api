<?php

namespace App\Modules\Auth\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Application\Mappers\UserDTOMapper;
use App\Modules\Auth\Domain\Interfaces\RepositoryInterface;

class AuthUserController extends Controller
{
    public function __construct(protected readonly RepositoryInterface $userRepository) {}

    public function __invoke()
    {
        $authUser = request()->get('user');
        $user = $this->userRepository->findById($authUser['id']);

        return response()->json([
            'data' => UserDTOMapper::toDTO($user),
            'message' => null,
            'error' => null,
            'errors' => null,
        ]);
    }
}

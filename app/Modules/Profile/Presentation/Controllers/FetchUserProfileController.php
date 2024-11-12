<?php

namespace App\Modules\Profile\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Profile\Application\UseCases\FetchUserProfileUseCase;
use Symfony\Component\HttpFoundation\Response;

class FetchUserProfileController extends Controller
{
    public function __construct(protected readonly FetchUserProfileUseCase $fetchUserProfileUseCase) {}

    public function __invoke($userId)
    {
        $authUser = request()->get('user');
        $profileData = $this->fetchUserProfileUseCase->handle($userId, $authUser ? $authUser['id'] : null);

        // Format the response
        return response()->json([
            'data' => $profileData,
            'message' => 'User Profile Fetched Successfully.',
            'errors' => null,
        ], Response::HTTP_OK);
    }
}

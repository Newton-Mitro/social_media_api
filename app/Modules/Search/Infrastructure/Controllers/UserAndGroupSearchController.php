<?php

namespace App\Modules\Search\Http\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\User\Models\User;
use App\Modules\Auth\User\UseCases\FetchUserProfileUseCase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAndGroupSearchController extends Controller
{
    public function __construct(protected readonly FetchUserProfileUseCase $fetchUserProfileUseCase) {}

    public function __invoke(Request $request)
    {
        $searchKeyword = $request->input('q');

        // Validate the search keyword
        if (empty($searchKeyword)) {
            return response()->json([
                'data' => [],
                'message' => 'No search keyword provided.',
                'errors' => ['keyword' => 'The search keyword is required.'],
            ], Response::HTTP_BAD_REQUEST);
        }

        // Fetch users
        $users = User::where('name', 'like', '%' . $searchKeyword . '%')
            ->orWhere('user_name', 'like', '%' . $searchKeyword . '%')
            ->orWhere('email', 'like', '%' . $searchKeyword . '%')
            ->get();


        return response()->json([
            'data' =>  $users,
            'message' => 'Search results fetched successfully.',
            'errors' => null,
        ], Response::HTTP_OK);
    }
}

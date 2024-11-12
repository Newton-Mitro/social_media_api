<?php

namespace App\Modules\Search\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAndGroupSearchController extends Controller
{
    public function __construct() {}

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

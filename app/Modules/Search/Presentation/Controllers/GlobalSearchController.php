<?php

namespace App\Modules\Search\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GlobalSearchController extends Controller
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

        // Fetch users and their posts based on the search keyword
        $results = User::with(['posts' => function ($query) use ($searchKeyword) {
            $query->where('body', 'like', '%' . $searchKeyword . '%');
        }])
            ->where(function ($query) use ($searchKeyword) {
                $query->where('name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('user_name', 'like', '%' . $searchKeyword . '%') // Assuming 'username' is the correct field
                    ->orWhere('email', 'like', '%' . $searchKeyword . '%') // Added email search
                    ->orWhereHas('posts', function ($query) use ($searchKeyword) {
                        $query->where('body', 'like', '%' . $searchKeyword . '%'); // Ensuring consistent field name
                    });
            })
            ->get();

        return response()->json([
            'data' => $results,
            'message' => 'Search results fetched successfully.',
            'errors' => null,
        ], Response::HTTP_OK);
    }
}

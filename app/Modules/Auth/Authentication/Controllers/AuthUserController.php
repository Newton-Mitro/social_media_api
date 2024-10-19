<?php

namespace App\Modules\Auth\Authentication\Controllers;

use App\Core\Controllers\Controller;

class AuthUserController extends Controller
{
    public function __construct() {}

    public function __invoke()
    {
        $user = request()->get('user');

        return response()->json([
            'data' => $user,
            'message' => null,
            'errors' => null,
        ]);
    }
}

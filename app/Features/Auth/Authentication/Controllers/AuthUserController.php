<?php

namespace App\Features\Auth\Authentication\Controllers;

use App\Core\Bus\IQueryBus;
use App\Core\Controllers\Controller;

class AuthUserController extends Controller
{
    public function __construct(
        protected IQueryBus $queryBus,
    ) {}

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

<?php

namespace App\Modules\Auth\Authentication\Controllers;


use App\Core\Controllers\Controller;
use App\Modules\Auth\Privacy\UseCases\Queries\GetPrivacyQuery;

class GetPrivacyController extends Controller
{
    public function __construct() {}

    public function __invoke()
    {
        $privacyList = $this->queryBus->ask(
            new GetPrivacyQuery(),
        );
        return response()->json([
            'data' => $privacyList,
            'message' => 'success',
            'errors' => null,
        ]);
    }
}

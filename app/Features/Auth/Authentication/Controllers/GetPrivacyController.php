<?php
namespace App\Features\Auth\Authentication\Controllers;


use App\Core\Bus\IQueryBus;
use App\Core\Controllers\Controller;
use App\Features\Auth\Privacy\UseCases\Queries\GetPrivacyQuery;

class GetPrivacyController extends Controller
{
    public function __construct(
        protected IQueryBus $queryBus,
    ) {
    }

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
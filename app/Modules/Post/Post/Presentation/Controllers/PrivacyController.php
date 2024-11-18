<?php

namespace App\Modules\Post\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Post\Application\UseCases\GetPrivaciesUseCase;
use Illuminate\Http\Response;

class PrivacyController extends Controller
{
    public function __construct(protected GetPrivaciesUseCase $getPrivaciesUseCase) {}

    public function index()
    {
        $res = $this->getPrivaciesUseCase->handle();
        return response()->json([
            'data' => $res,
            'message' => 'Successfully fetched privacies',
            'error' => null,
            'errors' => null,
        ], Response::HTTP_OK);
    }
}

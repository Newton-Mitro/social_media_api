<?php

namespace App\Modules\Content\Privacy\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Privacy\Application\UseCase\GetPrivaciesUseCase;
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

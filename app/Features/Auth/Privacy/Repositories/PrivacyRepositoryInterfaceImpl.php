<?php
namespace App\Features\Auth\Privacy\Repositories;

use Exception;
use Illuminate\Http\Response;
use App\Features\Auth\Privacy\Model\Privacy;
use App\Features\Auth\Privacy\Interfaces\PrivacyRepositoryInterface;

class PrivacyRepositoryInterfaceImpl implements PrivacyRepositoryInterface
{
    public function getPrivacy(): ?array
    {
        try {
            $privacyList = Privacy::all()->toArray();
            return $privacyList;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }
}
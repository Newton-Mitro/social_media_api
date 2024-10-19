<?php

namespace App\Features\Auth\BlacklistedToken\Repositories;

use App\Features\Auth\BlacklistedToken\BusinessModels\BlacklistedTokenModel;
use App\Features\Auth\BlacklistedToken\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Features\Auth\BlacklistedToken\Models\BlacklistedToken;
use Exception;
use Illuminate\Http\Response;

class BlacklistedTokenRepositoryImpl implements BlacklistedTokenRepositoryInterface
{
    public function addTokenToBlackList(BlacklistedTokenModel $model): int
    {
        try {
            $blacklistedToken = new BlacklistedToken;
            $blacklistedToken->id = $model->getId();
            $blacklistedToken->token = $model->getToken();
            $blacklistedToken->created_at = $model->getCreatedAt();
            $blacklistedToken->updated_at = $model->getUpdatedAt();
            $blacklistedToken->save();
            return $blacklistedToken->id;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }

    public function blacklistedTokenExist(string $token): bool
    {
        return BlacklistedToken::where('token', $token)->exists();
    }
}

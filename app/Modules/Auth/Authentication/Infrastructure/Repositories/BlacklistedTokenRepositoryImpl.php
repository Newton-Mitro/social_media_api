<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Repositories;

use App\Modules\Auth\Authentication\Domain\Entities\BlacklistedTokenModel;
use App\Modules\Auth\Authentication\Domain\Interfaces\BlacklistedTokenRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Models\BlacklistedToken;
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

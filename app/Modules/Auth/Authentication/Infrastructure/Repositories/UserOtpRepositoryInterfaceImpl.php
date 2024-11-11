<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Repositories;

use App\Modules\Auth\Authentication\Domain\Entities\UserOtpEntity;
use App\Modules\Auth\Authentication\Domain\Interfaces\UserOTPRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\UserOtpMapper;
use App\Modules\Auth\Authentication\Infrastructure\Models\UserOtp;
use Exception;
use Illuminate\Http\Response;

class UserOtpRepositoryInterfaceImpl implements UserOTPRepositoryInterface
{
    public function create(UserOtpEntity $userOtpModel): ?UserOtpEntity
    {
        try {
            $userOtp = new UserOtp;
            $userOtp->otp = $userOtpModel->getOtp();
            $userOtp->user_id = $userOtpModel->getUserId();
            $userOtp->expires_at = $userOtpModel->getExpiresAt();
            $userOtp->is_verified = $userOtpModel->getIsVerified();
            $userOtp->token = $userOtpModel->getToken();
            $userOtp->created_at = $userOtpModel->getCreatedAt();
            $userOtp->updated_at = $userOtpModel->getUpdatedAt();
            $userOtp->save();
            return UserOtpMapper::toBusinessModel($userOtp);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }

    public function findUserOTPByUserId(string $userId): ?UserOtpEntity
    {
        try {
            $userOtp = UserOtp::where('user_id', $userId)->first();
            if ($userOtp) {
                return UserOtpMapper::toBusinessModel($userOtp);
            }
            return null;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }
    public function update(UserOtpEntity $userOtpModel): ?UserOtpEntity
    {
        try {
            $userOtp = UserOtp::find($userOtpModel->getId());
            $userOtp->user_id = $userOtpModel->getUserId();
            $userOtp->otp = $userOtpModel->getOtp();
            $userOtp->expires_at = $userOtpModel->getExpiresAt();
            $userOtp->is_verified = $userOtpModel->getIsVerified();
            $userOtp->token = $userOtpModel->getToken();
            $userOtp->created_at = $userOtpModel->getCreatedAt();
            $userOtp->updated_at = $userOtpModel->getUpdatedAt();
            $userOtp->save();
            return UserOtpMapper::toBusinessModel($userOtp);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }
}

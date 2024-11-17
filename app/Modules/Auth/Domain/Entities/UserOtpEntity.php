<?php

namespace App\Modules\Auth\Domain\Entities;

use App\Core\Entities\BaseEntity;
use App\Core\Enums\OtpTypes;
use DateTimeImmutable;

class UserOtpEntity extends BaseEntity
{
        public function __construct(
                private string $userId,
                private OtpTypes $type,
                private DateTimeImmutable $expiresAt,
                private bool $isVerified = false,
                private ?string $otp = null,
                private ?string $token = null,
                private DateTimeImmutable $createdAt = new DateTimeImmutable,
                private DateTimeImmutable $updatedAt = new DateTimeImmutable,
                protected ?string $id = null,
        ) {
                parent::__construct($id);
        }

        public function getType()
        {
                return $this->type;
        }

        public function setType($type)
        {
                $this->type = $type;

                return $this;
        }

        public function getOtp()
        {
                return $this->otp;
        }

        public function setOtp($otp)
        {
                $this->otp = $otp;

                return $this;
        }

        public function getUserId()
        {
                return $this->userId;
        }

        public function setUserId($userId)
        {
                $this->userId = $userId;

                return $this;
        }

        public function getExpiresAt()
        {
                return $this->expiresAt;
        }

        public function setExpiresAt($expiresAt)
        {
                $this->expiresAt = $expiresAt;

                return $this;
        }

        public function getIsVerified()
        {
                return $this->isVerified;
        }

        public function setIsVerified($isVerified)
        {
                $this->isVerified = $isVerified;

                return $this;
        }

        public function getToken()
        {
                return $this->token;
        }

        public function setToken($token)
        {
                $this->token = $token;

                return $this;
        }

        public function getCreatedAt()
        {
                return $this->createdAt;
        }

        public function setCreatedAt($createdAt)
        {
                $this->createdAt = $createdAt;

                return $this;
        }

        public function getUpdatedAt()
        {
                return $this->updatedAt;
        }

        public function setUpdatedAt($updatedAt)
        {
                $this->updatedAt = $updatedAt;

                return $this;
        }
}

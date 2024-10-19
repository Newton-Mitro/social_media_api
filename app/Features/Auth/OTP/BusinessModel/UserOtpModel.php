<?php

namespace App\Features\Auth\OTP\BusinessModel;

use DateTimeImmutable;

class UserOtpModel
{
    public function __construct(
        private int $id,
        private string $otp,
        private int $userId,
        private DateTimeImmutable $expiresAt,
        private bool $isVerified = false,
        private ?string $token = null,
        private DateTimeImmutable $createdAt = new DateTimeImmutable,
        private DateTimeImmutable $updatedAt = new DateTimeImmutable
    ) {}

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of otp
         */ 
        public function getOtp()
        {
                return $this->otp;
        }

        /**
         * Set the value of otp
         *
         * @return  self
         */ 
        public function setOtp($otp)
        {
                $this->otp = $otp;

                return $this;
        }

        /**
         * Get the value of userId
         */ 
        public function getUserId()
        {
                return $this->userId;
        }

        /**
         * Set the value of userId
         *
         * @return  self
         */ 
        public function setUserId($userId)
        {
                $this->userId = $userId;

                return $this;
        }

        /**
         * Get the value of expiresAt
         */ 
        public function getExpiresAt()
        {
                return $this->expiresAt;
        }

        /**
         * Set the value of expiresAt
         *
         * @return  self
         */ 
        public function setExpiresAt($expiresAt)
        {
                $this->expiresAt = $expiresAt;

                return $this;
        }

        /**
         * Get the value of isVerified
         */ 
        public function getIsVerified()
        {
                return $this->isVerified;
        }

        /**
         * Set the value of isVerified
         *
         * @return  self
         */ 
        public function setIsVerified($isVerified)
        {
                $this->isVerified = $isVerified;

                return $this;
        }

        /**
         * Get the value of token
         */ 
        public function getToken()
        {
                return $this->token;
        }

        /**
         * Set the value of token
         *
         * @return  self
         */ 
        public function setToken($token)
        {
                $this->token = $token;

                return $this;
        }

        /**
         * Get the value of createdAt
         */ 
        public function getCreatedAt()
        {
                return $this->createdAt;
        }

        /**
         * Set the value of createdAt
         *
         * @return  self
         */ 
        public function setCreatedAt($createdAt)
        {
                $this->createdAt = $createdAt;

                return $this;
        }

        /**
         * Get the value of updatedAt
         */ 
        public function getUpdatedAt()
        {
                return $this->updatedAt;
        }

        /**
         * Set the value of updatedAt
         *
         * @return  self
         */ 
        public function setUpdatedAt($updatedAt)
        {
                $this->updatedAt = $updatedAt;

                return $this;
        }
}
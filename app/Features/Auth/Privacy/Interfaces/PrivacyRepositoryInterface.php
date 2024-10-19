<?php
namespace App\Features\Auth\Privacy\Interfaces;

use App\Features\Auth\Privacy\Model\Privacy;

interface PrivacyRepositoryInterface
{
    public function getPrivacy(): ?array;
}
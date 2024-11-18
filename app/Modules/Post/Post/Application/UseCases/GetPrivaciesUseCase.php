<?php

namespace App\Modules\Post\Application\UseCases;

use App\Modules\Post\Domain\Interfaces\PrivacyRepositoryInterface;

class GetPrivaciesUseCase
{
    public function __construct(
        protected PrivacyRepositoryInterface $privacyRepository
    ) {}

    public function handle()
    {
        return $this->privacyRepository->getPrivacies();
    }
}

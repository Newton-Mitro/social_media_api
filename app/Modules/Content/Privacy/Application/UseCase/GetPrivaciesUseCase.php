<?php

namespace App\Modules\Content\Privacy\Application\UseCase;

use App\Modules\Content\Privacy\Application\Mappers\PrivacyMapper;
use App\Modules\Content\Privacy\Domain\Repositories\PrivacyRepositoryInterface;


class GetPrivaciesUseCase
{
    public function __construct(
        protected PrivacyRepositoryInterface $privacyRepository
    ) {}

    public function handle()
    {
        $privacies = $this->privacyRepository->getPrivacies();
        return PrivacyMapper::toDTOCollection($privacies);
    }
}

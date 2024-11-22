<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Profile\Application\DTOs\ProfileAggregateDTO;
use App\Modules\Profile\Application\Mappers\ProfileAggregateMapper;
use App\Modules\Profile\Domain\Repositories\ProfileRepositoryInterface;

class FetchUserProfileUseCase
{
    public function __construct(
        protected ProfileRepositoryInterface $userProfileRepository,
    ) {}

    public function handle(string $userId, string $authUserId = null): ProfileAggregateDTO
    {
        $userProfileAggregate = $this->userProfileRepository->fetchUserProfile(
            $userId,
            $authUserId
        );

        return ProfileAggregateMapper::toDTO(
            $userProfileAggregate
        );
    }
}

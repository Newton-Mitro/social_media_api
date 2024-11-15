<?php

namespace App\Modules\Profile\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserDTOMapper;
use App\Modules\Auth\Domain\Interfaces\RepositoryInterface;
use App\Modules\Profile\Application\DTOs\ProfileAggregateDTO;
use App\Modules\Profile\Application\Mappers\ProfileAggregateDTOMapper;
use App\Modules\Profile\Domain\Interfaces\ProfileRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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

        return ProfileAggregateDTOMapper::toDTO(
            $userProfileAggregate
        );
    }
}

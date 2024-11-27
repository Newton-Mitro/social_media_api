<?php

namespace App\Modules\Follow\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserAggregateMapper;
use App\Modules\Follow\Domain\Repositories\FollowRepositoryInterface;
use Illuminate\Support\Collection;

class GetFollowingUseCase
{
    public function __construct(
        protected FollowRepositoryInterface $followRepository,
    ) {}

    public function handle(string $userId): Collection
    {
        $followings = $this->followRepository->getUserFollowings($userId);
        return UserAggregateMapper::toDTOCollection($followings);
    }
}

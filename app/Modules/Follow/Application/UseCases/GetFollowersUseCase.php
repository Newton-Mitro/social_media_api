<?php

namespace App\Modules\Follow\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserAggregateMapper;
use App\Modules\Follow\Domain\Repositories\FollowRepositoryInterface;
use Illuminate\Support\Collection;

class GetFollowersUseCase
{
    public function __construct(
        protected FollowRepositoryInterface $followRepository,
    ) {}

    public function handle(string $userId,): Collection
    {
        $followers = $this->followRepository->getUserFollowers($userId);
        return UserAggregateMapper::toDTOCollection($followers);
    }
}

<?php

namespace App\Modules\Friend\Application\UseCases;

use App\Modules\Auth\Application\Mappers\UserAggregateMapper;
use App\Modules\Friend\Domain\Repositories\FriendRepositoryInterface;
use Illuminate\Support\Collection;

class GetFriendsListUseCase
{
    private FriendRepositoryInterface $friendRepository;

    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    public function execute(string $userId): Collection
    {
        return UserAggregateMapper::toDTOCollection($this->friendRepository->findFriends($userId));
    }
}

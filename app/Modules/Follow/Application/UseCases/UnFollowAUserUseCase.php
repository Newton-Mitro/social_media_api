<?php

namespace App\Modules\Follow\Application\UseCases;

use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Follow\Domain\Repositories\FollowRepositoryInterface;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnFollowAUserUseCase
{
    public function __construct(
        protected FollowRepositoryInterface $followRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(string $following_id, string $follower_id): bool
    {
        // Check If Follower Already Following 
        $isFollowing = $this->followRepository->isFollowing($following_id, $follower_id);
        if (!$isFollowing) {
            throw new NotFoundHttpException('Not following.', null, Response::HTTP_NOT_FOUND);
        }

        // Persist Follow To Database
        return $this->followRepository->delete($isFollowing->getId());
    }
}

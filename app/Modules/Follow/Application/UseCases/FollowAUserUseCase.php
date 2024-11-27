<?php

namespace App\Modules\Follow\Application\UseCases;

use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Follow\Application\DTOs\FollowDTO;
use App\Modules\Follow\Application\Mappers\FollowMapper;
use App\Modules\Follow\Domain\Entities\FollowEntity;
use App\Modules\Follow\Domain\Repositories\FollowRepositoryInterface;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FollowAUserUseCase
{
    public function __construct(
        protected FollowRepositoryInterface $followRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(string $following_id, string $follower_id): FollowDTO
    {
        // Check If Follower Already Following 
        $isFollowing = $this->followRepository->isFollowing($following_id, $follower_id);
        if ($isFollowing) {
            throw new NotFoundHttpException('Already following.', null, Response::HTTP_NOT_FOUND);
        }

        // Find Following User Entity
        $followingUser = $this->userRepository->findById($following_id);
        if (!$followingUser) {
            throw new NotFoundHttpException('Following user do not exist.', null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Find Follower User Entity (Auth User)
        $followerUser = $this->userRepository->findById($follower_id);
        if (!$followerUser) {
            throw new NotFoundHttpException('Follower don not exist.', null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Create Follow Entity
        $followEntity = new FollowEntity(
            followerId: $follower_id,
            followingId: $following_id,
            follower: $followerUser,
            following: $followingUser
        );

        // Persist Follow To Database
        $this->followRepository->save($followEntity);

        return FollowMapper::toDTO($followEntity);
    }
}

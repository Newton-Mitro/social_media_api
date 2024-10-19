<?php
namespace App\Features\Post\UseCases\Commands\UpdatePostPrivacy;
use DateTimeImmutable;
use App\Core\Bus\Command;

class UpdatePostPrivacyCommand extends Command
{
    public function __construct(
        private readonly int $userId,
        private readonly int $postId,
        private readonly int $privacyId
    ) {
    }


    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get the value of postId
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Get the value of privacyId
     */
    public function getPrivacyId()
    {
        return $this->privacyId;
    }
}

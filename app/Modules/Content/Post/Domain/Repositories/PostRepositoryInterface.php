<?php

namespace App\Modules\Content\Post\Domain\Repositories;

use App\Modules\Content\Comment\Domain\Entities\CommentEntity;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Reaction\Domain\Entities\ReactionEntity;
use App\Modules\Content\Share\Domain\Entities\ShareEntity;
use App\Modules\Content\View\Domain\Entities\ViewEntity;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function getPosts(int $perPage = 10, int $offset = 0, ?string $auth_user_id = null): Collection;
    public function getUserPosts(int $limit = 10, int $offset = 0, string $userId, ?string $authUserId = null): Collection;
    public function save(PostAggregate $postAggregate): void;
    public function findById(string $postId): ?PostAggregate;
    public function delete(string $postId): void;

    public function reactToPost(PostAggregate $postAggregate, ReactionEntity $reactionEntity);
    public function getPostReactions(string $post_id);

    public function sharePost(PostAggregate $postAggregate, ShareEntity $shareEntity);
    public function getPostShares(string $post_id);

    public function viewPost(PostAggregate $postAggregate, ViewEntity $viewEntity);
    public function getPostViews(string $post_id);

    public function addPostComment(PostAggregate $postAggregate, CommentEntity $commentEntity);
    public function getPostComments(string $post_id);
}

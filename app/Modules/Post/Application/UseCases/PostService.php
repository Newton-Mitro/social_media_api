<?php

namespace App\Modules\Post\Application\UseCases;

use App\Modules\Post\Core\Interfaces\PostRepositoryInterface;
use App\Modules\Post\Core\Interfaces\PrivacyRepositoryInterface;


class PostService
{
    protected $postRepository;
    protected $privacyRepository;

    public function __construct(PostRepositoryInterface $postRepository, PrivacyRepositoryInterface $privacyRepository)
    {
        $this->postRepository = $postRepository;
        $this->privacyRepository = $privacyRepository;
    }

    public function getAllPosts(int $perPage, $userId)
    {
        return $this->postRepository->getPostsWithRelations($perPage, $userId);
    }

    public function getPostById(string $postId, string $userId)
    {
        return $this->postRepository->findByIdWithRelations($postId, $userId);
    }

    public function createPost($data, string $userId)
    {
        return $this->postRepository->create($data);
    }

    public function updatePost($id, $data)
    {
        return $this->postRepository->update($id, $data);
    }

    public function deletePost($id)
    {
        return $this->postRepository->delete($id);
    }

    public function likePost(string $postId, string $userId)
    {
        return $this->postRepository->like($postId, $userId);
    }

    public function unlikePost(string $postId, string $userId)
    {
        return $this->postRepository->unlike($postId, $userId);
    }

    public function sharePost(string $postId, string $userId)
    {
        return $this->postRepository->share($postId, $userId);
    }

    public function getPrivacies()
    {
        return $this->privacyRepository->getPrivacies();
    }
}

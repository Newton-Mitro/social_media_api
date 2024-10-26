<?php

namespace App\Modules\Post\Application\UseCases;

use App\Modules\Post\Core\Interfaces\PostRepositoryInterface;


class PostService
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts($perPage)
    {
        return $this->postRepository->getPostsWithRelations($perPage);
    }

    public function getPostById($id)
    {
        return $this->postRepository->findByIdWithRelations($id);
    }

    public function createPost($data)
    {
        $user = request()->get('user');
        $data['user_id'] = $user['user_id'];
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

    public function likePost($id)
    {
        $user = request()->get('user');
        return $this->postRepository->like($id, $user['user_id']);
    }

    public function unlikePost($id)
    {
        $user = request()->get('user');
        return $this->postRepository->unlike($id, $user['user_id']);
    }

    public function sharePost($id)
    {
        $user = request()->get('user');
        return $this->postRepository->share($id, $user['user_id']);
    }
}

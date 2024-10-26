<?php

namespace App\Modules\Post\Core\Interfaces;


interface PostRepositoryInterface
{
    public function getPostsWithRelations($perPage);
    public function findByIdWithRelations($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function like($id, $userId);
    public function unlike($id, $userId);
    public function share($id, $userId);
}

<?php

namespace App\Features\Post\UseCases\Commands\RemovePost;

use App\Features\Post\Interfaces\PostRepositoryInterface;
use App\Features\Post\UseCases\Commands\RemovePost\RemovePostCommand;
use Exception;
use Illuminate\Http\Response;

class RemovePostCommandHandler
{
    public function __construct(
        protected PostRepositoryInterface $repository,
    ) {}

    public function handle(RemovePostCommand $command): string
    {
        $command->getPostModel()->is_active = 0;
        if ($command->getPostModel()->save()) {
            return "Success";
        } else {
            throw new Exception("Post Removal Failed", Response::HTTP_BAD_REQUEST);
        }
    }
}

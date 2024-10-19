<?php
namespace App\Features\Post\UseCases\Commands\RemovePost;

use App\Core\Bus\CommandHandler;
use App\Core\Bus\ICommandBus;
use App\Core\Bus\IQueryBus;
use App\Features\Post\Interfaces\PostRepositoryInterface;
use App\Features\Post\UseCases\Commands\RemovePost\RemovePostCommand;
use Exception;
use Illuminate\Http\Response;

class RemovePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected PostRepositoryInterface $repository,
        protected ICommandBus             $commandBus,
        protected IQueryBus               $queryBus,
    )
    {
    }

    public function handle(RemovePostCommand $command): string
    {
        $command->getPostModel()->is_active = 0;
        if($command->getPostModel()->save()){
            return "Success";
        }else{
            throw new Exception("Post Removal Failed", Response::HTTP_BAD_REQUEST);
        }
    }
}

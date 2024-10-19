<?php
namespace App\Features\Post\UseCases\Commands\UpdatePostPrivacy;
use Exception;
use DateTimeImmutable;
use App\Core\Bus\IQueryBus;
use Illuminate\Http\Response;
use App\Core\Bus\CommandHandler;
use App\Features\Post\Models\Post;
use App\Features\Post\Interfaces\PostRepositoryInterface;
use App\Features\Post\UseCases\Queries\FindPost\FindPostByPostIdQuery;
use App\Features\Post\UseCases\Commands\UpdatePostPrivacy\UpdatePostPrivacyCommand;

class UpdatePostPrivacyCommandHandler extends CommandHandler
{
    public function __construct(
        protected IQueryBus $queryBus
    ) {
    }
    public function handle(UpdatePostPrivacyCommand $command): void
    {
        $post = Post::find($command->getPostId());
         if ($post === null) {
             throw new Exception('No post found', Response::HTTP_NOT_FOUND);
         }
         else {
            $post->update([
                'privacy_setting_id' => $command->getPrivacyId(),
                'modified_at'=> new DateTimeImmutable()
            ]);

         }
    }
}

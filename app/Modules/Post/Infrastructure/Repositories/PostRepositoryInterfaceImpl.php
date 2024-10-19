<?php

namespace App\Modules\Post\Repositories;

use Exception;
use DateTimeImmutable;
use App\Core\Bus\IQueryBus;
use App\Core\Bus\ICommandBus;
use Illuminate\Http\Response;
use App\Modules\Post\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Modules\Post\BusinessModels\PostModel;
use App\Modules\Post\Interfaces\PostRepositoryInterface;
use App\Modules\Auth\User\UseCases\Queries\FindUser\FindUserQuery;
use App\Modules\Post\Mappers\PostMapper;
use App\Modules\Post\UseCases\Commands\UpdatePost\UpdatePostCommand;

class PostRepositoryInterfaceImpl implements PostRepositoryInterface
{
    public function __construct(
        protected ICommandBus $commandBus,
        protected IQueryBus $queryBus,
    ) {}

    public function getPostsByUser(int $userId, int $startRec, int $pageSize): array
    {
        try {
            $mappedPosts = [];
            DB::statement('SET @out_message = NULL;');
            // Call the stored procedure with the user ID and OUT parameter
            $posts = DB::select('CALL sp_get_user_content_posts(?,?,?,@out_message)', [$userId, $startRec, $pageSize]);
            // Retrieve the OUT parameter
            $result = DB::select('SELECT @out_message AS message');
            $message = $result[0]->message;
            if ($posts) {
                $mappedPosts =  PostMapper::toPostModelArray($posts);
            }
            return $mappedPosts;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(PostModel $postModel): string
    {
        try {
            $attachments = [];
            foreach ($postModel->getAttachments() as $attachment) {
                $attachments[] = [
                    'content_name' => $attachment->getFileName(),
                    'content_url' => $attachment->getFilePath(),
                    'content_type' => $attachment->getMimeType(),
                ];
            };
            $jsonAttachment = $attachments ? json_encode($attachments) : '';
            $post = DB::select('CALL sp_insert_user_content_posting(?,?,?,?,@Message)', [$postModel->getUserId(), $postModel->getBody(), $postModel->getPrivacyId(), $jsonAttachment]);
            $results = DB::select('select @Message as message ');
            return $results[0]->message;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }

    public function update(PostModel $postModel): string
    {
        try {
            $attachments = [];
            foreach ($postModel->getAttachments() as $attachment) {
                $attachments[] = [
                    'content_name' => $attachment->getFileName(),
                    'content_url' => $attachment->getFilePath(),
                    'content_type' => $attachment->getMimeType(),
                ];
            };
            $jsonAttachment = $attachments ? json_encode($attachments) : '';
            $post = DB::select('CALL sp_update_user_content_posting(?,?,?,?,?,?,@Message)', [$postModel->getPostId(), $postModel->getUserId(), $postModel->getBody(), $postModel->getExistingContentUrl(), $postModel->getPrivacyId(), $jsonAttachment]);
            $results = DB::select('select @Message as message ');
            return $results[0]->message;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
        }
    }
}

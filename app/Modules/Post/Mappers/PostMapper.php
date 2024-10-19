<?php

namespace App\Modules\Post\Mappers;

use App\Modules\Auth\User\BusinessModels\UserModel;
use App\Modules\Auth\User\Mappers\UserMapper;
use App\Modules\Auth\User\Resources\UserResource;
use App\Modules\Post\BusinessModels\AttachmentModel;
use App\Modules\Post\BusinessModels\PostModel;
use App\Modules\Post\Resources\AttachmentResource;
use App\Modules\Post\Resources\PostResource;
use DateTimeImmutable;

class PostMapper
{
    public static function toPostModelArray(array $results): array
    {
        $posts = [];
        foreach ($results as $row) {
            $postId = $row->user_contents_post_id;
            // Check if the post already exists in the array
            if (!isset($posts[$postId])) {
                $postModel = new PostModel(
                    $row->user_contents_post_id,
                    $row->user_id,
                    $row->content_header_text,
                    '',
                    $row->privacy_setting_id,
                    $row->user_id,
                    new UserModel($row->user_id, $row->name, $row->user_name, $row->email),
                    [],
                    $row->like_count,
                    0,
                    $row->share_count,
                    true,
                    new DateTimeImmutable($row->content_post_date),
                    new DateTimeImmutable(), // new DateTimeImmutable($row->modified_at),
                    new DateTimeImmutable($row->content_expire_date)
                );
                $posts[$postId] = $postModel;
            }
            // Add attachments to the post  (user_content_id)
            if ($row->user_content_id) {
                $attachmentModel = new AttachmentModel(
                    $row->user_content_id,
                    $row->user_contents_post_id,
                    $row->content_name,
                    'need path field',
                    $row->content_url,
                    $row->content_type,
                    $row->user_id
                );
                $posts[$postId]->attachments[] = $attachmentModel;
            }
        }
        return $posts;
    }

    public static function toPostResourceArray(array $postModels): array
    {
        $postResources = [];
        foreach ($postModels as $postModel) {
            $postResource = new PostResource();
            $postResource->postId = $postModel->getPostId();
            $postResource->userId = $postModel->getUserId();
            $postResource->body = $postModel->getBody();
            $postResource->privacyId = $postModel->getPrivacyId();
            $postResource->createdAt = $postModel->getCreatedAt()->format('Y-m-d H:i:s');
            $postResource->expireDate = $postModel->getExpireDate()->format('Y-m-d H:i:s');
            $postResource->attachments = self::toAttachmentResourceArray($postModel->getAttachments() ?? []);
            $postResource->createdBy = $postModel->getCreatedBy();
            $postResource->creator = UserMapper::toUserResource($postModel->getCreator());
            $postResources[] = $postResource;
        }
        return $postResources;
    }

    public static function toAttachmentResourceArray(array $attachmentModels): array
    {
        $attachmentResources = [];
        foreach ($attachmentModels as $attachmentModel) {
            $attachmentResource = new AttachmentResource();
            $attachmentResource->attachmentId = $attachmentModel->getAttachmentId();
            $attachmentResource->postId = $attachmentModel->getPostId();
            $attachmentResource->fileName = $attachmentModel->getFileName();
            $attachmentResource->filePath = $attachmentModel->getFilePath();
            $attachmentResource->fileURL = $attachmentModel->getFileURL();
            $attachmentResource->mimeType = $attachmentModel->getMimeType();
            $attachmentResource->createdBy = $attachmentModel->getCreatedBy();
            $attachmentResource->likeCount = $attachmentModel->getLikeCount();
            $attachmentResource->viewCount = $attachmentModel->getViewCount();
            $attachmentResource->shareCount = $attachmentModel->getShareCount();
            $attachmentResource->createdAt = $attachmentModel->getCreatedAt()->format('Y-m-d H:i:s');
            $attachmentResource->updatedAt = $attachmentModel->getUpdatedAt()->format('Y-m-d H:i:s');
            $attachmentResources[] = $attachmentResource;
        }
        return $attachmentResources;
    }
}

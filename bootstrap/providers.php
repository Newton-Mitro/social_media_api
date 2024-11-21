<?php

use App\Modules\Auth\AuthServiceProvider;
use App\Modules\Follow\FollowServiceProvider;
use App\Modules\Friend\FriendServiceProvider;
use App\Modules\Profile\ProfileServiceProvider;
use App\Modules\Content\Post\PostServiceProvider;
use App\Modules\Content\View\ViewServiceProvider;
use App\Modules\Content\Share\ShareServiceProvider;
use App\Modules\Content\Comment\CommentServiceProvider;
use App\Modules\Content\Privacy\PrivacyServiceProvider;
use App\Modules\StorageFile\StorageFileServiceProvider;
use App\Modules\Content\Reaction\ReactionServiceProvider;
use App\Modules\Content\Attachment\AttachmentServiceProvider;

return [
    AuthServiceProvider::class,
    StorageFileServiceProvider::class,
    ProfileServiceProvider::class,
    FollowServiceProvider::class,
    FriendServiceProvider::class,
    PrivacyServiceProvider::class,
    PostServiceProvider::class,
    AttachmentServiceProvider::class,
    CommentServiceProvider::class,
    ReactionServiceProvider::class,
    ViewServiceProvider::class,
    ShareServiceProvider::class,
];

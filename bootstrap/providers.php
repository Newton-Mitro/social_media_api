<?php

use App\Modules\Auth\AuthServiceProvider;
use App\Modules\Follow\FollowServiceProvider;
use App\Modules\Friend\FriendServiceProvider;
use App\Modules\Content\PostServiceProvider;
use App\Modules\Profile\ProfileServiceProvider;
use App\Modules\StorageFile\Providers\StorageFileServiceProvider;


return [
    AuthServiceProvider::class,
    PostServiceProvider::class,
    StorageFileServiceProvider::class,
    ProfileServiceProvider::class,
    FollowServiceProvider::class,
    FriendServiceProvider::class,
];

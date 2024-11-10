<?php

use App\Modules\Auth\Authentication\AuthServiceProvider;
use App\Modules\Post\PostServiceProvider;
use App\Modules\StorageFile\Providers\StorageFileServiceProvider;






return [
    AuthServiceProvider::class,
    PostServiceProvider::class,
    StorageFileServiceProvider::class,
];

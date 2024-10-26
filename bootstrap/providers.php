<?php

use App\Modules\Post\Providers\PostServiceProvider;
use App\Modules\Auth\OTP\Providers\OtpServiceProvider;
use App\Modules\Auth\User\Providers\UserServiceProvider;
use App\Modules\Auth\Device\Providers\DeviceServiceProvider;
use App\Modules\Auth\Authentication\Providers\AuthServiceProvider;
use App\Modules\Auth\BlacklistedToken\Providers\BlacklistedTokenServiceProvider;
use App\Modules\StorageFile\Providers\StorageFileServiceProvider;

return [
    AuthServiceProvider::class,
    UserServiceProvider::class,
    PostServiceProvider::class,
    DeviceServiceProvider::class,
    BlacklistedTokenServiceProvider::class,
    OtpServiceProvider::class,
    StorageFileServiceProvider::class,
];

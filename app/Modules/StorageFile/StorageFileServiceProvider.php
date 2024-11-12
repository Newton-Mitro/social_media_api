<?php

namespace App\Modules\StorageFile;

use App\Modules\StorageFile\Application\UseCases\FileUploadService;
use App\Modules\StorageFile\Core\Interfaces\FileUploadServiceInterface;
use Illuminate\Support\ServiceProvider;

class StorageFileServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind the interface to the concrete service class
        $this->app->bind(FileUploadServiceInterface::class, FileUploadService::class);
    }
}

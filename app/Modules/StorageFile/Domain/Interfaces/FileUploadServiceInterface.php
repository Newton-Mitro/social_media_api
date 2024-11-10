<?php

namespace App\Modules\StorageFile\Core\Interfaces;

use Illuminate\Http\UploadedFile;


interface FileUploadServiceInterface
{
    public function uploadFile(UploadedFile $file): array;
}

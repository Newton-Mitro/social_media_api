<?php

namespace App\Modules\StorageFile\Domain\Interfaces;

use Illuminate\Http\UploadedFile;


interface FileUploadServiceInterface
{
    public function uploadFile(UploadedFile $file): array;
}

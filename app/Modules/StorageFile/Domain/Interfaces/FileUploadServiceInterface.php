<?php

namespace App\Modules\StorageFile\Domain\Interfaces;

use App\Modules\StorageFile\Application\DTOs\UploadedFileDTO;
use Illuminate\Http\UploadedFile;


interface FileUploadServiceInterface
{
    public function uploadFile(UploadedFile $file): UploadedFileDTO;
}

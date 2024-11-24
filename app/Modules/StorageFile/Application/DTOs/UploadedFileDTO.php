<?php

namespace App\Modules\StorageFile\Application\DTOs;

class UploadedFileDTO
{
    public string $file_url;
    public ?string $file_path;
    public ?string $file_name;
    public ?string $thumbnail_url;
    public string $mime_type;
    public ?string $title;
    public ?string $description;
    public float $duration;
}

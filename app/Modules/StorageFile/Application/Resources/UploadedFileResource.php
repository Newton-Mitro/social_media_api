<?php

namespace App\Modules\StorageFile\Application\Resources;

class UploadedFileResource
{
    public string $url;
    public string $path;
    public string $file_name;
    public string $file_type;

    public function __construct(string $url, string $path, string $file_name, string $file_type)
    {
        $this->url = $url;
        $this->path = $path;
        $this->file_name = $file_name;
        $this->file_type = $file_type;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'path' => $this->path,
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
        ];
    }
}

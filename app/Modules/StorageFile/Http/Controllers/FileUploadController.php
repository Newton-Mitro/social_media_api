<?php

namespace App\Modules\StorageFile\Http\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\StorageFile\Application\Resources\FileUploadRequest;
use App\Modules\StorageFile\Core\Interfaces\FileUploadServiceInterface;
use App\Modules\StorageFile\DTOs\FileUploadDTO;
use Illuminate\Http\JsonResponse;

class FileUploadController extends Controller
{
    protected FileUploadServiceInterface $fileUploadService;

    public function __construct(FileUploadServiceInterface $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function upload(FileUploadRequest $request): JsonResponse
    {
        // Use the service to handle file upload
        $fileData = $this->fileUploadService->uploadFile($request->file('file'));

        // Create DTO from the file data
        $fileUploadDTO = new FileUploadDTO($fileData['url'], $fileData['path'], $fileData['file_name'], $fileData['file_type']);

        // Return response with data from the DTO
        return response()->json([
            'data' => $fileUploadDTO->toArray(),
            'message' => 'File uploaded successfully.',
            'errors' => null,
        ], 201);
    }
}

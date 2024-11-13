<?php

namespace App\Modules\StorageFile\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\StorageFile\Application\DTOs\UploadedFileDTO;
use App\Modules\StorageFile\Domain\Interfaces\FileUploadServiceInterface;
use App\Modules\StorageFile\Presentation\Request\FileUploadRequest;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $fileUploadDTO = new UploadedFileDTO($fileData['url'], $fileData['path'], $fileData['file_name'], $fileData['file_type']);

        // Return response with data from the DTO
        return response()->json([
            'data' => $fileUploadDTO->toArray(),
            'message' => 'File uploaded successfully.',
            'errors' => null,
        ], 201);
    }

    function getLinkInfo(Request $request)
    {
        // Fetch the HTML content from the URL
        $html = @file_get_contents($request->get('permalink'));

        if ($html === false) {
            return []; // Return empty if unable to fetch
        }

        // Create a new DOMDocument instance
        $dom = new DOMDocument;

        // Suppress errors due to malformed HTML
        libxml_use_internal_errors(true);

        // Load the HTML content
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Initialize variables to hold the data
        $title = '';
        $description = '';
        $thumbnail = '';

        // Get Open Graph meta tags
        foreach ($dom->getElementsByTagName('meta') as $meta) {
            $property = $meta->getAttribute('property');
            $content = $meta->getAttribute('content');

            // Get title, description, and image from Open Graph properties
            if ($property === 'og:title') {
                $title = $content;
            } elseif ($property === 'og:description') {
                $description = $content;
            } elseif ($property === 'og:image') {
                $thumbnail = $content;
            }
        }

        // Fallback to regular title and description if Open Graph is not present
        if (empty($title)) {
            $titleTags = $dom->getElementsByTagName('title');
            if ($titleTags->length > 0) {
                $title = $titleTags->item(0)->textContent;
            }
        }

        if (empty($description)) {
            foreach ($dom->getElementsByTagName('meta') as $meta) {
                $name = $meta->getAttribute('name');
                if ($name === 'description') {
                    $description = $meta->getAttribute('content');
                    break;
                }
            }
        }

        $res = [
            'title' => $title,
            'description' => $description,
            'thumbnail_url' => $thumbnail,
            'type' => 'link'
        ];

        return response()->json([
            'data' => $res,
            'message' => 'Fetched link info successfully.',
            'errors' => null,
        ], 200);
    }
}

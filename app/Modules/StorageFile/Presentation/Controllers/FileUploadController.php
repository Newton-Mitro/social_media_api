<?php

namespace App\Modules\StorageFile\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\StorageFile\Domain\Interfaces\FileUploadServiceInterface;
use App\Modules\StorageFile\Presentation\Request\FileUploadRequest;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{

    public function __construct(protected FileUploadServiceInterface $fileUploadService) {}

    public function upload(FileUploadRequest $request): JsonResponse
    {
        // Use the service to handle file upload
        $fileData = $this->fileUploadService->uploadFile($request->file('attachment'));

        // Return response with data from the DTO
        return response()->json([
            'data' =>  $fileData,
            'message' => 'File uploaded successfully.',
            'errors' => null,
        ], 201);
    }

    function getLinkInfo(Request $request)
    {
        $url = $request->input('permalink');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL'], 400);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return response()->json(['error' => 'Unable to fetch URL'], 500);
        }

        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $metaData = ['url' => $url, 'title' => '', 'description' => '', 'image' => ''];

        // Extract title
        $titleTags = $doc->getElementsByTagName('title');
        if ($titleTags->length > 0) {
            $metaData['title'] = trim($titleTags->item(0)->textContent);
        }

        // Extract meta tags
        foreach ($doc->getElementsByTagName('meta') as $meta) {
            $property = strtolower($meta->getAttribute('property'));
            $name = strtolower($meta->getAttribute('name'));
            $content = trim($meta->getAttribute('content'));

            if ($property === 'og:title' || $name === 'title') {
                $metaData['title'] = $content ?: $metaData['title'];
            }
            if ($property === 'og:description' || $name === 'description') {
                $metaData['description'] = $content ?: $metaData['description'];
            }
            if ($property === 'og:image') {
                $metaData['image'] = $content ?: $metaData['image'];
            }
        }

        return response()->json(['metadata' => $metaData, 'message' => 'Fetched link meta successfully.'], 200);
    }


// regx for email valdation 

    public function getLinkMeta(Request $request)
    {
        $url = $request->input('url');

        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL'], 400);
        }

        // Fetch HTML content
        $context = stream_context_create(['http' => ['ignore_errors' => true]]);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return response()->json(['error' => 'Unable to fetch URL'], 500);
        }

        // Load HTML into DOMDocument
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML($html);
        libxml_clear_errors();

        // Extract metadata
        $metaData = [
            'url' => $url,
            'title' => '',
            'description' => '',
            'image' => '',
        ];

        // Get <title> tag
        $titleTags = $doc->getElementsByTagName('title');
        if ($titleTags->length > 0) {
            $metaData['title'] = $titleTags->item(0)->textContent;
        }

        // Get <meta> tags
        foreach ($doc->getElementsByTagName('meta') as $meta) {
            $name = strtolower($meta->getAttribute('name'));
            $property = strtolower($meta->getAttribute('property'));
            $content = $meta->getAttribute('content');

            if ($name === 'description' || $property === 'og:description') {
                $metaData['description'] = $content;
            }

            if ($property === 'og:image') {
                $metaData['image'] = $content;
            }
        }

        // Fallback to regular title and description if Open Graph is not present
        if (empty($title)) {
            $titleTags = $doc->getElementsByTagName('title');
            if ($titleTags->length > 0) {
                $title = $titleTags->item(0)->textContent;
            }
        }

        if (empty($description)) {
            foreach ($doc->getElementsByTagName('meta') as $meta) {
                $name = $meta->getAttribute('name');
                if ($name === 'description') {
                    $description = $meta->getAttribute('content');
                    break;
                }
            }
        }


        return response()->json([
            'metadata' => $metaData,
            'message' => 'Fetched link meta successfully.',
            'errors' => null,
        ], 200);
    }
}

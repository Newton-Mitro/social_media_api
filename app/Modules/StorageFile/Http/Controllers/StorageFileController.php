<?php

namespace App\Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Core\Controllers\Controller;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,pdf,doc,docx|max:2048', // Adjust types and size limit as needed
        ]);

        // Store the file
        $path = $request->file('file')->store('uploads', 'public');

        // Return response
        return response()->json([
            'data' => [
                'url' => Storage::url($path),  // Get the public URL of the uploaded file
                'path' => $path,
            ],
            'message' => 'File uploaded successfully.',
            'errors' => null,
        ], 201);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CleanupUnusedFiles extends Command
{
    protected $signature = 'cleanup:unused-files';
    protected $description = 'Delete unused files from storage';

    public function handle()
    {
        // Fetch used files from the database
        $usedFiles = DB::table('attachments')->pluck('path')->toArray();

        // Fetch all files from the storage
        $allFiles = Storage::files('uploads'); // Adjust the path as necessary

        // Identify unused files
        $unusedFiles = array_diff($allFiles, $usedFiles);

        // Delete unused files
        foreach ($unusedFiles as $file) {
            try {
                Storage::delete($file);
            } catch (\Exception $e) {
                $this->error('Error deleting file ' . $file . ': ' . $e->getMessage());
            }
        }

        $this->info(count($unusedFiles) . ' unused files deleted.');
    }
}

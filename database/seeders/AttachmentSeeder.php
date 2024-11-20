<?php

namespace Database\Seeders;

use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    public function run()
    {
        Attachment::factory()->count(30)->create();
    }
}

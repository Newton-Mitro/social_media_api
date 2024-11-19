<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Content\Infrastructure\Models\Attachment;

class AttachmentSeeder extends Seeder
{
    public function run()
    {
        Attachment::factory()->count(30)->create();
    }
}

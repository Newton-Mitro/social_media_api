<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Auth\User\Models\User;
use App\Modules\Post\Infrastructure\Models\Like;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Share;
use App\Modules\Post\Infrastructure\Models\Comment;
use App\Modules\Post\Infrastructure\Models\Privacy;
use App\Modules\Post\Infrastructure\Models\Attachment;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $userEmails = [
            'test@email.com',
            'john.doe@email.com',
            'jenny.smith@email.com',
        ];

        foreach ($userEmails as $value) {
            User::factory()->create([
                'email' => $value,
            ]);
        }



        $privacyValues = [
            'Public',
            'Friends',
            'Only Me',
            'Friends of Friend',
        ];

        // Insert fixed privacy values if not already present
        foreach ($privacyValues as $value) {
            Privacy::firstOrCreate(['privacy_name' => $value]);
        }

        // Retrieve all privacy records
        $privacies = Privacy::all();

        // Create posts and related data for each privacy
        $privacies->each(function ($privacy) {
            $posts = Post::factory()->count(5)->create(['privacy_id' => $privacy->id]);

            foreach ($posts as $post) {
                Comment::factory()->count(3)->create(['post_id' => $post->id]);
                Attachment::factory()->count(2)->create(['post_id' => $post->id]);
                Like::factory()->count(2)->create(['post_id' => $post->id]);
                Share::factory()->count(1)->create(['post_id' => $post->id]);
            }
        });
    }
}

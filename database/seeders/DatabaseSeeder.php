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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User emails to create
        $userEmails = [
            'test@email.com',
            'john.doe@email.com',
            'jenny.smith@email.com',
        ];

        // Create users
        foreach ($userEmails as $email) {
            User::factory()->create(['email' => $email]);
        }

        // Privacy values to insert
        $privacyValues = [
            'Public',
            'Friends',
            'Only Me',
            'Friends of Friend',
        ];

        // Insert privacy values if not already present
        foreach ($privacyValues as $privacyName) {
            Privacy::firstOrCreate(['privacy_name' => $privacyName]);
        }

        // Retrieve all privacy records
        $privacies = Privacy::all();

        // Create posts and related data for each privacy
        $privacies->each(function ($privacy) {
            // Create posts for each privacy
            $posts = Post::factory()->count(5)->create(['privacy_id' => $privacy->id, 'user_id' => User::inRandomOrder()->first()->id]);

            // For each post, create comments, attachments, likes, and shares
            foreach ($posts as $post) {
                Comment::factory()->count(3)->create(['commentable_id' => $post->id, 'commentable_type' => Post::class, 'user_id' => User::first()->id]);
                Attachment::factory()->count(2)->create(['post_id' => $post->id]);
                Like::factory()->count(2)->create(['likable_id' => $post->id, 'likable_type' => Post::class, 'user_id' => User::first()->id]);
                Share::factory()->count(1)->create(['post_id' => $post->id, 'user_id' => User::first()->id]);
            }
        });
    }
}

<?php

namespace Database\Seeders;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Follow\Infrastructure\Models\Follow;
use App\Modules\Friend\Infrastructure\Models\FriendRequest;
use App\Modules\Post\Infrastructure\Models\Attachment;
use App\Modules\Post\Infrastructure\Models\Comment;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Privacy;
use App\Modules\Post\Infrastructure\Models\Reaction;
use App\Modules\Post\Infrastructure\Models\Share;
use Illuminate\Database\Seeder;

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
            $posts = Post::factory()->count(5)->create([
                'privacy_id' => $privacy->id,
                'user_id' => User::inRandomOrder()->first()->id
            ]);

            foreach ($posts as $post) {
                // Create comments if they don't already exist
                Comment::factory()->count(3)->create([
                    'commentable_id' => $post->id,
                    'commentable_type' => Post::class,
                    'user_id' => User::inRandomOrder()->first()->id
                ]);

                // Create attachments if they don't already exist
                Attachment::factory()->count(2)->create(['post_id' => $post->id]);

                // Ensure unique reactions by checking before creation
                foreach (['like', 'love', 'haha', 'wow', 'sad', 'angry'] as $reactionType) {
                    Reaction::firstOrCreate([
                        'reactable_id' => $post->id,
                        'reactable_type' => Post::class,
                        'user_id' => User::inRandomOrder()->first()->id,
                        'type' => $reactionType,
                    ]);
                }

                // Create shares if they don't already exist
                Share::factory()->count(1)->create([
                    'post_id' => $post->id,
                    'user_id' => User::inRandomOrder()->first()->id
                ]);
            }
        });

        // Get the top three users
        $topUsers = User::take(3)->get();

        // Seed follows, and friend requests among top three users only

        // Seed follows
        foreach ($topUsers as $follower) {
            foreach ($topUsers as $following) {
                if ($follower->id !== $following->id) {
                    Follow::firstOrCreate([
                        'follower_id' => $follower->id,
                        'following_id' => $following->id
                    ]);
                }
            }
        }

        // Seed friend requests
        foreach ($topUsers as $sender) {
            foreach ($topUsers as $receiver) {
                if ($sender->id !== $receiver->id) {
                    // Randomize the status (pending, accepted, or rejected)
                    FriendRequest::firstOrCreate([
                        'sender_id' => $sender->id,
                        'receiver_id' => $receiver->id,
                        'status' => fake()->randomElement(['pending', 'accepted', 'rejected'])
                    ]);
                }
            }
        }
    }
}

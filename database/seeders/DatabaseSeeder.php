<?php

namespace Database\Seeders;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use App\Modules\Content\Comment\Infrastructure\Models\Comment;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Privacy\Infrastructure\Models\Privacy;
use App\Modules\Content\Reaction\Infrastructure\Models\Reaction;
use App\Modules\Content\Share\Infrastructure\Models\Share;
use App\Modules\Follow\Infrastructure\Models\Follow;
use App\Modules\Friend\Infrastructure\Models\FriendRequest;
use App\Modules\Profile\Infrastructure\Models\Profile;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Faker instance
        $faker = Faker::create();

        // User emails to create
        $userEmails = [
            'test@email.com',
            'john.doe@email.com',
            'jenny.smith@email.com',
        ];

        // Create users
        foreach ($userEmails as $email) {
            $user = User::factory()->create(['email' => $email]);
            Profile::factory()->create([
                'user_id' => $user->id
            ]);
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
            Privacy::factory()->create(['privacy_name' => $privacyName]);
        }

        // Retrieve all privacy records
        $privacies = Privacy::all();

        // Create posts and related data for each privacy
        $privacies->each(function ($privacy) use ($faker) {
            // Create posts for each privacy
            $posts = Post::factory()->count(5)->create([
                'privacy_id' => $privacy->id,
                'user_id' => User::inRandomOrder()->first()->id
            ]);

            foreach ($posts as $post) {
                // Create comments with a mix of parent and child comments
                $postComments = Comment::factory()->count(3)->create([
                    'commentable_id' => $post->id,
                    'commentable_type' => Post::class,
                    'user_id' => User::inRandomOrder()->first()->id
                ]);

                foreach ($postComments as $comment) {
                    // Randomly decide if the comment is a reply to another comment
                    if ($faker->boolean) {
                        $parentComment = $postComments->random();
                        $comment->update(['parent_id' => $parentComment->id]);
                    }
                }

                // Create attachments if they don't already exist
                Attachment::factory()->count(2)->create(['post_id' => $post->id]);

                // Ensure unique reactions by checking before creation
                foreach (['Like', 'Love', 'Haha', 'Wow', 'Sad', 'Angry'] as $reactionType) {
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
                        'status' => $faker->randomElement(['Pending', 'Accepted'])
                    ]);
                }
            }
        }
    }
}

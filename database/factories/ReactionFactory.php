<?php

namespace Database\Factories;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Post\Infrastructure\Models\Comment;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Reaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReactionFactory extends Factory
{
    protected $model = Reaction::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'reactable_id' => $this->faker->uuid, // Assuming reactable_id is a UUID
            'reactable_type' => $this->faker->randomElement([Post::class, Comment::class]),
            'user_id' => User::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['Like', 'Love', 'Haha', 'Wow', 'Sad', 'Angry']),
        ];
    }
}

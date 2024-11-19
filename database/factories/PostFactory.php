<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Privacy\Infrastructure\Models\Privacy;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'privacy_id' => Privacy::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'id' => Str::uuid(),
            'post_text' => $this->faker->paragraph,
            'comment_count' => $this->faker->numberBetween(0, 100),
            'share_count' => $this->faker->numberBetween(0, 100),
            'view_count' => $this->faker->numberBetween(0, 100),
            'reaction_count' => $this->faker->numberBetween(0, 100),
            'location' => $this->faker->city,
        ];
    }
}

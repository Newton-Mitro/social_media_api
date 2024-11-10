<?php

namespace Database\Factories;

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Privacy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'body' => $this->faker->paragraph,
            'likes' => $this->faker->numberBetween(0, 100),
            'shares' => $this->faker->numberBetween(0, 100),
            'location' => $this->faker->city,
            'privacy_id' => Privacy::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Post\Infrastructure\Models\Attachment;

class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition()
    {
        return [
            'post_id' => Post::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['image', 'video', 'link', 'document']),
            'url' => $this->faker->url,
            'thumbnail_url' => $this->faker->optional()->url,
            'description' => $this->faker->optional()->sentence,
            'duration' => $this->faker->optional()->numberBetween(1, 120),
            'likes' => $this->faker->numberBetween(0, 100),
            'shares' => $this->faker->numberBetween(0, 100),
        ];
    }
}

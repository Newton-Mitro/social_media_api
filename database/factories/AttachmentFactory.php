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
        $type = $this->faker->randomElement(['image', 'video', 'link', 'document']);

        // Create specific URLs based on attachment type
        switch ($type) {
            case 'image':
                $url = $this->faker->imageUrl();
                $thumbnail_url = $this->faker->imageUrl(150, 150); // Thumbnail for image
                break;
            case 'video':
                $url = $this->faker->url; // URL for video
                $thumbnail_url = $this->faker->imageUrl(150, 150); // Thumbnail for video
                break;
            case 'link':
                $url = $this->faker->url; // URL for a link
                $thumbnail_url = null; // Links typically don’t have thumbnails
                break;
            case 'document':
                $url = $this->faker->url; // URL for a document
                $thumbnail_url = null; // Documents typically don’t have thumbnails
                break;
            default:
                $url = $this->faker->url; // Fallback URL
                $thumbnail_url = null;
        }

        return [
            'post_id' => Post::inRandomOrder()->first()->id,
            'type' => $type,
            'url' => $url,
            'thumbnail_url' => $thumbnail_url,
            'description' => $this->faker->optional()->sentence,
            'duration' => $type === 'video' ? $this->faker->optional()->numberBetween(1, 120) : null,
            'likes' => $this->faker->numberBetween(0, 100),
        ];
    }
}

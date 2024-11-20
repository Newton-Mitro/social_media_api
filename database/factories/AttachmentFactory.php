<?php

namespace Database\Factories;

use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
                $url = "https://firebasestorage.googleapis.com/v0/b/christosangeet-afa3a.appspot.com/o/videos%2FElephantsDream.mp4?alt=media&token=8f62ea2b-ce3d-4df0-b510-55c4b8e8f2c3"; // URL for video
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
            'id' => Str::uuid(),
            'post_id' => Post::inRandomOrder()->first()->id,
            'mime_type' => $type,
            'file_url' => $url,
            'file_path' => $this->faker->filePath(), // Random file path
            'file_name' => $this->faker->word . '.' . $this->faker->fileExtension, // Random file name
            'thumbnail_url' => $thumbnail_url,
            'description' => $this->faker->optional()->sentence,
            'duration' => $type === 'video' ? $this->faker->numberBetween(1, 120) : 0,
            'comment_count' => $this->faker->numberBetween(0, 100),
            'share_count' => $this->faker->numberBetween(0, 100),
            'view_count' => $this->faker->numberBetween(0, 100),
            'reaction_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}

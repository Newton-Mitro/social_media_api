<?php

namespace Database\Factories;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Share\Infrastructure\Models\Share;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShareFactory extends Factory
{
    protected $model = Share::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'post_id' => Post::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}

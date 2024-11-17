<?php

namespace Database\Factories;

use App\Modules\Post\Infrastructure\Models\Privacy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PrivacyFactory extends Factory
{
    protected $model = Privacy::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'privacy_name' => $this->faker->word,
        ];
    }
}

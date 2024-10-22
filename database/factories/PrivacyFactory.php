<?php

namespace Database\Factories;

use App\Modules\Post\Infrastructure\Models\Privacy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivacyFactory extends Factory
{
    protected $model = Privacy::class;

    public function definition()
    {
        return [
            'privacy_name' => $this->faker->word,
        ];
    }
}

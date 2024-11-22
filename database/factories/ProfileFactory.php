<?php

namespace Database\Factories;

use App\Modules\Auth\Infrastructure\Models\Profile;
use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),  // Generate a UUID for the id
            'user_id' => User::inRandomOrder()->first()->id,  // Use a random User's ID
            'sex' => $this->faker->randomElement(['Male', 'Female', 'Others']),  // Randomly select a sex
            'dbo' => $this->faker->dateTimeBetween('-60 years', '-18 years'),  // Random date of birth, making sure age is 18+
            'mobile_number' => $this->faker->optional()->phoneNumber,
            'profile_picture' => $this->faker->optional()->imageUrl(300, 300, 'people'),  // Random profile picture URL
            'cover_photo' => $this->faker->optional()->imageUrl(800, 300, 'nature'),  // Random cover photo URL
            'bio' => $this->faker->optional()->sentence,  // Random bio text
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

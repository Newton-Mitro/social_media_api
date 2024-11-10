<?php

namespace Database\Factories;

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'user_name' => $this->faker->unique()->userName,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'profile_picture' => $this->faker->imageUrl(640, 480, 'people'),
            'cover_photo' => $this->faker->imageUrl(1280, 720, 'nature'),
            'otp' => $this->faker->optional()->numerify('######'),
            'otp_expires_at' => $this->faker->optional()->dateTimeBetween('now', '+1 hour'),
            'otp_verified' => $this->faker->boolean(50), // 50% chance of being true
            'last_logged_in' => $this->faker->optional()->dateTime(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

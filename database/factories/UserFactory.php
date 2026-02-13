<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Enums\UserRole;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->numerify('09#########'),
            
            'role' => UserRole::User,

            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('Userpass@pmslocal'),
            'remember_token' => Str::random(10),
        ];
    }

    // Role States

    public function admin(): static
    {
        return $this->state(fn () => ['role' => UserRole::Admin]);
    }

    public function manager(): static
    {
       return $this->state(fn () => ['role' => UserRole::Manager]);
    }

    public function user(): static
    {
        return $this->state(fn ()=>[
            'role' => 'user',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn () => ['role' => UserRole::User]);
    }
}

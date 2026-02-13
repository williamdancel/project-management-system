<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => fake()->randomElement([
                'I have completed this task.',
                'There is an issue with validation.',
                'Please review the latest changes.',
                'I pushed updates to the repository.',
                'Waiting for feedback.',
                'This task depends on another feature.',
                'Tested and working properly.',
                'Need clarification on requirements.',
                'Optimized the query performance.',
                'UI adjustments applied.',
            ]) . ' ' . fake()->optional()->sentence(),

            // Set in seeder to avoid creating new tasks/users
            'task_id' => null,
            'user_id' => null,
        ];
    }
}

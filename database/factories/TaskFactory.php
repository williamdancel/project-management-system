<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Enums\TaskStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Make status realistic
        $status = fake()->randomElement(TaskStatus::cases());

        // Make due_date realistic based on status
        $dueDate = match ($status) {
            'done' => fake()->dateTimeBetween('-30 days', '-1 day'),
            'in-progress' => fake()->dateTimeBetween('-7 days', '+14 days'),
            default => fake()->dateTimeBetween('now', '+30 days'),
        };

        return [
            'title' => fake()->randomElement([
                'Implement login UI',
                'Fix validation issues',
                'Create CRUD module',
                'Optimize query performance',
                'Add activity logs',
                'Refactor components',
                'Create export feature',
                'Update project settings',
                'Improve error handling',
                'Write unit tests',
                'Polish UI spacing',
            ]) . ' - ' . fake()->words(2, true),

            'description' => fake()->optional(0.85)->paragraph(2),

            'status' => $status,
            'due_date' => $dueDate->format('Y-m-d'),

            // Set these in TaskSeeder to ensure FK points to existing rows
            'project_id' => null,
            'assigned_to' => null,
        ];
    }
}

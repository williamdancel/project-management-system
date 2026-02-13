<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
     protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-60 days', '+10 days');
        $end = fake()->boolean(70)
            ? fake()->dateTimeBetween($start, '+120 days')
            : null;

        return [
            'title' => fake()->randomElement([
                'Website Redesign',
                'Mobile App MVP',
                'Internal Admin Panel',
                'POS Improvements',
                'Client Portal Build',
                'Marketing Landing Pages',
                'Support Ticket System',
                'Inventory Module',
            ]) . ' - ' . fake()->words(2, true),

            'description' => fake()->optional(0.85)->paragraph(2),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end?->format('Y-m-d'),
            'created_by' => null,
        ];
    }
}

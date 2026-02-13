<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creatorIds = User::query()
            ->whereIn('role', ['admin', 'manager'])
            ->pluck('id');

        Project::factory()
            ->count(5)
            ->make()
            ->each(function ($project) use ($creatorIds) {
                $project->created_by = $creatorIds->random();
                $project->save();
            });
    }
}

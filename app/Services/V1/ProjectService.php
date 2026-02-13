<?php

namespace App\Services\V1;

use App\Models\Project;
use App\Models\User;

class ProjectService
{
    public function list(int $perPage = 10)
    {
        return Project::with('creator')
            ->withCount('tasks')
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data, User $actor): Project
    {
        return Project::create([
            ...$data,
            'created_by' => $actor->id,
        ]);
    }

    public function show(Project $project): Project
    {
        return $project->load(['creator', 'tasks']);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project->fresh();
    }

    public function delete(Project $project): void
    {
        $project->delete();
    }
}

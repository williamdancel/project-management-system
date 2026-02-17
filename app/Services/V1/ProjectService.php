<?php

namespace App\Services\V1;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ProjectService
{
    public function list(int $perPage = 10)
    {
        $key = "projects:list:perPage={$perPage}:page=".(request('page', 1));

        return Cache::remember($key, now()->addMinutes(10), function () use ($perPage) {
            return Project::with('creator')
                ->withCount('tasks')
                ->latest()
                ->paginate($perPage);
        });
    }

    public function create(array $data, User $actor): Project
    {
        $project = Project::create([
            ...$data,
            'created_by' => $actor->id,
        ]);

        $this->clearProjectsCache();

        return $project;
    }

    public function show(Project $project): Project
    {
        return $project->load(['creator', 'tasks']);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);

        $this->clearProjectsCache();
        return $project->fresh();
    }

    public function delete(Project $project): void
    {
        $project->delete();
        $this->clearProjectsCache();
    }
    private function clearProjectsCache(): void
    {
        Cache::flush();
    }
}

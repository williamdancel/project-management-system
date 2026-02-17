<?php

namespace App\Services\V1;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskService
{
    public function __construct(
        private TaskAssignmentServices $assignment
    ) {}

    public function tasksByProject(Project $project, int $perPage = 10)
    {
        return $project->tasks()
            ->with(['assignee'])
            ->latest()
            ->paginate($perPage);
    }

    public function tasksByProjectFiltered(
        Project $project,
        ?string $status,
        ?string $search,
        int $perPage = 10
    ) {
        return $project->tasks()
            ->with(['assignee'])
            ->filterByStatus($status)
            ->searchByTitle($search)    
            ->latest()
            ->paginate($perPage);
    }

    public function createForProject(Project $project, array $data): Task
    {
        return $project->tasks()->create($data);
    }

    public function show(Task $task): Task
    {
        return $task->load(['project', 'assignee', 'comments.user']);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh();
    }

    public function assign(Task $task, int $assigneeId): Task
    {
        return $this->assignment->assign($task, $assigneeId);
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }

    public function myTasks(User $user, int $perPage = 10)
    {
        return Task::with('project')
            ->where('assigned_to', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    public function myTasksFiltered(
        User $user,
        ?string $status,
        ?string $search,
        int $perPage = 10
    ) {
        return Task::query()
            ->with('project')
            ->where('assigned_to', $user->id)
            ->filterByStatus($status)
            ->searchByTitle($search)
            ->latest()
            ->paginate($perPage);
    }
}

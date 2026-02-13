<?php

namespace App\Services\V1;

use App\Models\Task;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class TaskAssignmentService
{
    public function assign(Task $task, int $assigneeId): Task
    {
        $assignee = User::find($assigneeId);

        if (! $assignee) {
            throw ValidationException::withMessages([
                'assigned_to' => ['User not found.'],
            ]);
        }

        if ($assignee->role !== 'user') {
            throw ValidationException::withMessages([
                'assigned_to' => ['Only users with role "user" can be assigned tasks.'],
            ]);
        }

        $task->assigned_to = $assignee->id;
        $task->save();

        return $task->fresh(['assignee', 'project']);
    }
}

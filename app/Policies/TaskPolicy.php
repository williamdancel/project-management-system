<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function update(User $user, Task $task): bool
    {
        return $user->role === 'manager'
            || (int) $task->assigned_to === (int) $user->id;
    }

    // Optional if to restrict GET /tasks/{id}
    public function view(User $user, Task $task): bool
    {
        return $user->role === 'manager'
            || (int) $task->assigned_to === (int) $user->id;
    }
}

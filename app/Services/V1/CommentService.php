<?php

namespace App\Services\V1;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CommentService
{
    public function listForTask(Task $task, User $actor)
    {
        return $task->comments()
            ->with('user')
            ->latest()
            ->get();
    }

    public function createForTask(Task $task, User $actor, array $data): Comment
    {

        return Comment::create([
            'body' => $data['body'],
            'task_id' => $task->id,
            'user_id' => $actor->id,
        ])->load('user');
    }

}

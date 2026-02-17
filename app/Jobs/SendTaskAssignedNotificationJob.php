<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTaskAssignedNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $taskId,
        public int $userId
    ) {}

    public function handle(): void
    {
        $task = Task::find($this->taskId);
        $user = User::find($this->userId);

        if (! $task || ! $user) {
            return;
        }

        $user->notify(new TaskAssignedNotification($task));
    }
}

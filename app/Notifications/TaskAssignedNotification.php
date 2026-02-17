<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Task Assigned: '.$this->task->title)
            ->greeting('Hi '.$notifiable->name.'!')
            ->line('A new task has been assigned to you.')
            ->line('Task: '.$this->task->title)
            ->line('Status: '.((string) $this->task->status))
            ->line('Due Date: '.($this->task->due_date ?? 'N/A'))
            ->action('View Task', url('/')) // replace with frontend URL if available
            ->line('Thank you.');
    }
}

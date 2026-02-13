<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class CommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_assigned_user_can_add_comment(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $project = Project::factory()->create();

        $task = Task::factory()->create([
            'project_id' => $project->id,
            'assigned_to' => $user->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/v1/tasks/{$task->id}/comments", [
                'body' => 'Hello comment',
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('comments', [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'body' => 'Hello comment',
        ]);
    }
}

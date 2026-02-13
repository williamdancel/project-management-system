<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_task_under_project(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $project = Project::factory()->create();

        $response = $this->actingAs($manager, 'sanctum')
            ->postJson("/api/v1/projects/{$project->id}/tasks", [
                'title' => 'Task 1',
                'description' => 'Test task',
                'status' => 'pending',
                'due_date' => now()->addDays(2)->toDateString(),
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('tasks', [
            'title' => 'Task 1',
            'project_id' => $project->id,
        ]);
    }

    public function test_assigned_user_can_update_task(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $project = Project::factory()->create();

        $task = Task::factory()->create([
            'project_id' => $project->id,
            'assigned_to' => $user->id,
            'title' => 'Old',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/v1/tasks/{$task->id}", [
                'title' => 'New Title',
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'New Title',
        ]);
    }

    public function test_unassigned_user_cannot_update_task(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);
        $project = Project::factory()->create();

        $task = Task::factory()->create([
            'project_id' => $project->id,
            'assigned_to' => $otherUser->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson("/api/v1/tasks/{$task->id}", [
                'title' => 'Hacked',
            ]);

        $response->assertForbidden();
    }
}

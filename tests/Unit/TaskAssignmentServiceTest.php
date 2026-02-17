<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\V1\TaskAssignmentServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssignmentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_assigns_task_to_user_role_user(): void
    {
        $service = app(TaskAssignmentServices::class);

        $project = Project::factory()->create();

        $task = Task::factory()->create([
            'project_id' => $project->id,
            'assigned_to' => null,
        ]);

        $assignee = User::factory()->create([
            'role' => 'user',
        ]);

        $updated = $service->assign($task, $assignee->id);

        $this->assertEquals($assignee->id, $updated->assigned_to);
    }
}

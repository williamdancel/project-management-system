<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_project(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/projects', [
                'title' => 'Project A',
                'description' => 'Desc',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(5)->toDateString(),
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('projects', ['title' => 'Project A']);
    }

    public function test_non_admin_cannot_create_project(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/projects', [
                'title' => 'Project B',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addDays(2)->toDateString(),
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('projects', ['title' => 'Project B']);
    }
}

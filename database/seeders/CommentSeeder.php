<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taskIds = Task::query()->pluck('id');
        $userIds = User::query()->pluck('id');

        // Safety check
        if ($taskIds->isEmpty() || $userIds->isEmpty()) {
            return;
        }

        // Create exactly 10 comments
        for ($i = 0; $i < 10; $i++) {
            Comment::factory()->create([
                'task_id' => $taskIds->random(),
                'user_id' => $userIds->random(),
            ]);
        }
    }
}

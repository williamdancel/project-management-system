<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Tasks\StoreTaskRequest;
use App\Http\Requests\Api\V1\Tasks\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\V1\TaskService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private TaskService $tasks) {}

    public function tasksByProject(Project $project, Request $request): JsonResponse
    {
        $status = $request->query('status');
        $search = $request->query('search');

        return response()->json(
            $this->tasks->tasksByProjectFiltered($project, $status, $search)
        );
    }

    public function storeForProject(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $task = $this->tasks->createForProject($project, $request->validated());

        return response()->json($task, 201);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json($this->tasks->show($task));
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);

        return response()->json(
            $this->tasks->update($task, $request->validated())
        );
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->tasks->delete($task);

        return response()->json(['message' => 'Deleted']);
    }

    public function myTasks(Request $request): JsonResponse
    {
        $status = $request->query('status');
        $search = $request->query('search');

        return response()->json(
            $this->tasks->myTasksFiltered($request->user(), $status, $search)
        );
    }


    public function assign(Request $request, Task $task): JsonResponse
    {
        $data = $request->validate([
            'assigned_to' => ['required', 'integer', 'exists:users,id'],
        ]);

        $updated = $this->tasks->assign($task, (int) $data['assigned_to']);

        return response()->json($updated);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Projects\StoreProjectRequest;
use App\Http\Requests\Api\V1\Projects\UpdateProjectRequest;
use App\Models\Project;
use App\Services\V1\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projects) {}

    public function index(): JsonResponse
    {
        return response()->json($this->projects->list());
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projects->create($request->validated(), $request->user());

        return response()->json($project, 201);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json($this->projects->show($project));
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        return response()->json(
            $this->projects->update($project, $request->validated())
        );
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->projects->delete($project);

        return response()->json(['message' => 'Deleted']);
    }
}
